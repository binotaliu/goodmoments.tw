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

/** !
 * UUIDGeneratorBrowser from https://www.30secondsofcode.org/js/s/uuid-generator-browser
 * Licensed under CC-BY-4.0
 */
export const uuid4 = () => ([1e7] + -1e3 + -4e3 + -8e3 + -1e11)
  .replace(/[018]/g, c =>
    (
      c ^
      (crypto.getRandomValues(new Uint8Array(1))[0] & (15 >> (c / 4)))
    ).toString(16)
  )
