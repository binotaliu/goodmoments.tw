import Alpine from 'alpinejs'
import Swiper, { Navigation, Pagination } from 'swiper'

window.Swiper = Swiper
window.swiperModules = [Navigation, Pagination]

window.Alpine = Alpine

Alpine.data('header', () => ({
  showMenu: false,
  toggleMenu () {
    this.showMenu = !this.showMenu
  }
}))

Alpine.start()
