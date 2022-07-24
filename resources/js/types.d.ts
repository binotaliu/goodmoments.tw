/* eslint-disable @typescript-eslint/no-unused-vars,camelcase,@typescript-eslint/no-explicit-any,no-use-before-define */
type Concrete<T> = { [Property in keyof T]-?: T[Property] }

type ClassAttr = (string | { [index: string]: boolean })[] | { [index: string]: boolean }

declare function route(name: string, params?: string | number | string[] | number[] | object | object[], absolute?: boolean, config?: Ziggy.Config): string
declare function route(): Ziggy.Router

declare namespace Ziggy {
  type Config = { [key: string]: any }

  interface Router {
    current: ((name: string, params: string | number | string[] | number[] | object | object[]) => boolean) | (() => string)
    params: { [key: string]: string | number }
    has: (name: string) => boolean
    check: (name: string) => boolean
    toString: () => string
  }
}
