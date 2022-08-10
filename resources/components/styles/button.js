export const base = [
  'border rounded',
  'font-bold',
  'outline-none focus:outline-none',
  'transition-colors duration-50',
  'hover:cursor-pointer',
  'disabled:hover:cursor-not-allowed'
]

export const theme = {
  DEFAULT: [
    'text-pearl-800 disabled:text-pearl-600',
    'border-pearl-600',
    'bg-pearl-500 hover:bg-pearl-400 active:bg-pearl-600 disabled:bg-pearl-400'
  ],
  primary: [
    'disabled:text-gray-700',
    'border-sun-600',
    'bg-sun-500 hover:bg-sun-400 active:bg-sun-600 disabled:bg-sun-400'
  ],
  danger: [
    'text-pearl-100 disabled:text-pearl-600',
    'border-red-600',
    'bg-red-500 hover:bg-red-400 active: bg-red-600 disabled:bg-red-400'
  ]
}

export const size = {
  sm: [
    'px-2 py-1',
    'text-sm'
  ],
  DEFAULT: [
    'px-6 py-2',
    'text-base'
  ],
  lg: [
    'px-10 py-3',
    'text-base'
  ]
}
