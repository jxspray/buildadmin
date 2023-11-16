import createAxios from '/@/utils/axios'
import { useSiteConfig } from '/@/stores/siteConfig'
import { UploadRawFile } from 'element-plus'
import { randomNum, shortUuid } from '/@/utils/random'
import { fullUrl } from '/@/utils/common'
import { isAdminApp } from '/@/utils/common'
import { AxiosRequestConfig } from 'axios'
import { createMinioClient, fileToStream } from 'tz-minio-upload_beta'
import jsSHA from 'jssha'


export const state = () => {
    const siteConfig = useSiteConfig()
    return siteConfig.upload.mode == 'local' ? 'disable' : 'enable'
}
/**
 *
 * @export 上传文件（stream流方法）
 * @param {*} backetName String 存储桶名字
 * @param {*} fileObj Object 文件对象
 * @param {*} path String 文件存储路径
 * @param {*} vm Object 调用该方法的页面的this
 * @return {*} null
 */
export async function uploadMinIo(backetName,fileObj, path, vm) {
    if (
        fileObj
    ) {
        let file = fileObj;
        console.log("file", file);
        //判断是否选择了文件
        if (file == undefined) {
            //未选择
        } else {
            //选择
            // 获取文件类型及大小
            // 给文件名加上当前时间
            const fileName = getNowTime("time") + file.name;
            const fileDate = getNowTime("fileDate") // 生成以日为分类的文件夹
            const mineType = file.type;
            const fileSize = file.size;
            console.log("fileName", fileName);
            //参数
            let metadata = {
                "content-type": mineType,
                "content-length": fileSize,
            };
            //判断储存桶是否存在
            minioClient.bucketExists(backetName, function (err) {
                console.log("判断储存桶是否存在");
                if (err) {
                    if (err.code == "NoSuchBucket")
                        return console.log("bucket does not exist.");
                    return console.log(err);
                }
                //准备上传
                let reader = new FileReader();
                console.log(reader);
                reader.readAsDataURL(file);
                reader.onloadend = function (e) {
                    //读取完成触发，无论成功或失败
                    console.log("ee", e);
                    const dataurl = e.target.result;
                    //base64转blob
                    const blob = toBlob(dataurl);
                    //blob转arrayBuffer
                    let reader2 = new FileReader();
                    reader2.readAsArrayBuffer(blob);
                    reader2.onload = function (ex) {
                        //定义流
                        let bufferStream = new stream.PassThrough();
                        //将buffer写入

                        bufferStream.end(Buffer.from(ex.target.result));
                        //上传
                        minioClient.putObject(
                            backetName,
                            `${path}/${fileDate}/${fileName}`,
                            bufferStream,
                            fileSize,
                            metadata,
                            function (err, etag) {
                                // console.log("dddddd");
                                if (err == null) { // 为空则代表上传成功
                                    let res = {
                                        path: `http://192.168.0.226:30014/${backetName}/${path}/${fileDate}/${fileName}`,
                                        result: 1,
                                    };
                                    // 成功生成url后调用
                                    // 调用传进来的this的的方法，然后通过该方法把成功事件发送出去
                                    vm.handleAvatarSuccess(res, vm.filedname);
                                    vm.fileName = fileName;
                                    vm.$message({
                                        message: "上传成功！",
                                        type: "success",
                                    });
                                    // 由于minio设置了永久链接，该生成临时url的方法就不再使用
                                    // minioClient.presignedGetObject(
                                    //   "medialibrary",
                                    //   `archive${a}${fileName}`,
                                    //   24 * 60 * 60,
                                    //   function (err, presignedUrl) {
                                    //     if (err) return console.log(err);
                                    //     let res = {
                                    //       path: presignedUrl,
                                    //       result: 1,
                                    //     };
                                    //     // 成功生成url后调用
                                    //     vm.handleAvatarSuccess(res, vm.filedname);
                                    //     vm.fileName = fileName;
                                    //     vm.$message({
                                    //       message: "上传成功！",
                                    //       type: "success",
                                    //     });
                                    //     console.log("链接：",presignedUrl);
                                    //   }
                                    // );
                                }
                            }
                        );
                    };
                };
            });
        }
    } else {
        this.$message({
            message: "文件类型错误！",
            type: "error",
        });
    }
}
const siteConfig = useSiteConfig()
const minioClient = createMinioClient({
    endPoint: siteConfig.upload.url, // 地址
    useSSL: true, // 是否使用ssl
    accessKey: siteConfig.upload.accessKey, // 登录的accessKey
    secretKey: siteConfig.upload.secretKey // secretKey
});
export async function fileUpload(fd: FormData, params: anyObj = {}, config: AxiosRequestConfig = {}) {
    const siteConfig = useSiteConfig()
    const file = fd.get('file') as UploadRawFile
    const sha1 = await getFileSha1(file)
    const fileKey = getSaveName(file, sha1)
    minioClient.bucketExists(VITE_minio_BUCKET_NAME, function (err) {
        if (err) {
            if (err.code == 'NoSuchBucket') {
                return console.log('bucket does not exist.')
            }
            return console.log(err)
        } else {
            console.log('bucket exist.')
        }
        const type = file.type
        const size = file.size
        // 参数
        const metadata = {
            'content-type': type,
            'content-length': size
        }
        fileToStream(file, (data) => {
            let buf = data._readableState.buffer.head.data
            minioClient.putObject(siteConfig.upload.bucket, file.name, buf, size, metadata, (err, data) => {
                console.log(6666);
                if (err) {
                    resolve(null)
                    return
                }
                resolve(data)
            })
        })
    })
    return ;

    fd.append('key', fileKey)
    for (const key in siteConfig.upload.params) {
        fd.append(key, siteConfig.upload.params[key])
    }
    // 接口要求file排在最后
    fd.delete('file')
    fd.append('file', file)
    return new Promise(async (resolve, reject) => {
        createAxios({
            url: siteConfig.upload.url,
            method: 'POST',
            data: fd,
            params: params,
            timeout: 0,
            ...config,
        })
            .then(() => {
                const fileUrl = '/' + fileKey
                createAxios({
                    url: isAdminApp() ? '/admin/Alioss/callback' : '/api/Alioss/callback',
                    method: 'POST',
                    data: {
                        url: fileUrl,
                        name: file.name,
                        size: file.size,
                        type: file.type,
                        sha1: sha1,
                    },
                })
                resolve({
                    code: 1,
                    data: {
                        file: {
                            full_url: fullUrl(fileUrl),
                            url: fileUrl,
                        },
                    },
                    msg: '',
                    time: Date.now(),
                })
            })
            .catch((res) => {
                reject({
                    code: 0,
                    data: res,
                    msg: res.message,
                    time: Date.now(),
                })
            })
    }) as ApiPromise
}

export function getSaveName(file: UploadRawFile, sha1: string) {
    const fileSuffix = file.name.substring(file.name.lastIndexOf('.') + 1)
    const fileName = file.name.substring(0, file.name.lastIndexOf('.'))
    const dateObj = new Date()

    const replaceArr: anyObj = {
        '{topic}': 'default',
        '{year}': dateObj.getFullYear(),
        '{mon}': ('0' + (dateObj.getMonth() + 1)).slice(-2),
        '{day}': dateObj.getDate(),
        '{hour}': dateObj.getHours(),
        '{min}': dateObj.getMinutes(),
        '{sec}': dateObj.getSeconds(),
        '{random}': shortUuid(),
        '{random32}': randomNum(32, 32),
        '{filename}': fileName.substring(0, 15),
        '{suffix}': fileSuffix,
        '{.suffix}': '.' + fileSuffix,
        '{filesha1}': sha1,
    }
    const replaceKeys = Object.keys(replaceArr).join('|')
    const siteConfig = useSiteConfig()

    const savename = siteConfig.upload.savename[0] == '/' ? siteConfig.upload.savename.slice(1) : siteConfig.upload.savename

    return savename.replace(new RegExp(replaceKeys, 'gm'), (match) => {
        return replaceArr[match]
    })
}

async function getFileSha1(file: UploadRawFile) {
    const shaObj = new jsSHA('SHA-1', 'ARRAYBUFFER')
    shaObj.update(await file.arrayBuffer())
    return shaObj.getHash('HEX')
}
