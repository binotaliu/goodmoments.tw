import Alpine from 'alpinejs'
import Swiper, { Autoplay, Navigation, Pagination } from 'swiper'

window.Swiper = Swiper

Swiper.use([Autoplay, Navigation, Pagination])

window.Alpine = Alpine

Alpine.data('header', () => ({
  showMenu: false,
  toggleMenu () {
    this.showMenu = !this.showMenu
  }
}))

Alpine.start()
