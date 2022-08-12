import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.data('header', () => ({
  showMenu: false,
  toggleMenu () {
    this.showMenu = !this.showMenu
  }
}))

Alpine.start()
