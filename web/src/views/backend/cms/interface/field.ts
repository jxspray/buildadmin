export interface FieldType {
    value: any
    label: string
    icon: string
    type: string
}

export interface FormFieldType {
    field: string
    label: string
    type?: FieldType
}

export interface ElFieldForm {
    setShow: boolean
    setIndex: number,
    setForm: FormFieldType
}
