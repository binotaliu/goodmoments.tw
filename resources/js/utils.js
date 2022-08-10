export const clone = (v) => JSON.parse(JSON.stringify(v))

export const mapObjectIntoFormData = (object, fieldName, formData) => {
  if (Array.isArray(object)) {
    object.forEach((value, i) => {
      mapObjectIntoFormData(value, `${fieldName}[${i}]`, formData)
    })
    return
  }

  if (typeof object === 'object') {
    Object.keys(object).forEach((key) => {
      mapObjectIntoFormData(object[key], `${fieldName}[${key}]`, formData)
    })
    return
  }

  formData.append(fieldName, object)
}
