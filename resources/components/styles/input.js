export const base = (hasIcon) => [
  'relative',
  hasIcon ? 'pl-10' : 'pl-2',
  'w-full pl-10 pr-2 py-1',
  'border border-gray-100 focus:border-wood-300',
  'outline-none focus:outline-none',
  'focus:ring focus:ring-wood-500',
  'rounded',
  'bg-white',
  'text-sm',
  'placeholder-gray-300 text-gray-600',
  'shadow',
  'motion-safe:focus:md:scale-[1.02]',
  'transition-transform'
]
