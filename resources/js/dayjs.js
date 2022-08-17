import dayjs from 'dayjs'
import relativeTime from 'dayjs/plugin/relativeTime'
import utc from 'dayjs/plugin/utc'
import isSameOrBefore from 'dayjs/plugin/isSameOrBefore'
import isSameOrAfter from 'dayjs/plugin/isSameOrAfter'

import 'dayjs/locale/zh-tw'

dayjs.locale('zh-tw')
dayjs.extend(relativeTime)
dayjs.extend(utc)
dayjs.extend(isSameOrBefore)
dayjs.extend(isSameOrAfter)

window.dayjs = dayjs

export default dayjs
