<template>
    <div class="bg-main-500 text-white text-sm font-medium w-full h-16 fixed top-0 z-20 nav-shadow flex items-center justify-between lg:justify-start space-x-8 lg:space-x-4">
        <div class="bg-white w-full lg:w-1/3 h-full rounded-br-3xl grid grid-cols-2 pr-8 lg:pr-4 xl:pr-8">
            <div class="flex items-center justify-center">
                <img src="/assets/logo_nestle.png" alt="" class="object-contain">
            </div>
            <div class="flex items-center justify-start">
                <img src="/assets/logo_benavides.png" alt="" class="object-contain">
            </div>
        </div>
        <div class="text-center hidden lg:grid grid-cols-6 gap-x-2">
            <div class="flex justify-center items-center">
                <inertia-link :href="route('index')"
                              :class="route().current('index') ? 'border-white' : 'border-transparent'"
                              class="transition border-b-2 duration-200 hover:border-white">HOME</inertia-link>
            </div>
            <div class="flex justify-center items-center">
                <inertia-link :href="route('how_to_participe')"
                              :class="route().current('how_to_participe') ? 'border-white' : 'border-transparent'"
                              class="transition border-b-2 duration-200 hover:border-white">CÓMO PARTICIPAR</inertia-link>
            </div>
            <div class="flex justify-center items-center">
                <inertia-link :href="route('awards')"
                              :class="route().current('awards') ? 'border-white' : 'border-transparent'"
                              class="transition border-b-2 duration-200 hover:border-white">PREMIOS</inertia-link>
            </div>
            <div class="flex justify-center items-center">
                <inertia-link :href="route('participant_products')"
                              :class="route().current('participant_products') ? 'border-white' : 'border-transparent'"
                              class="transition border-b-2 duration-200 hover:border-white">PRODUCTOS PARTICIPANTES</inertia-link>
            </div>
            <div class="flex justify-center items-center">
                <inertia-link :href="route('winners')"
                              :class="route().current('winners') ? 'border-white' : 'border-transparent'"
                              class="transition border-b-2 duration-200 hover:border-white">GANADORES</inertia-link>
            </div>
            <div class="flex justify-center items-center">
                <inertia-link :href="route('contact')"
                              :class="route().current('contact') ? 'border-white' : 'border-transparent'"
                              class="transition border-b-2 duration-200 hover:border-white">CONTACTO</inertia-link>
            </div>
        </div>
        <button @click="openSidebar()" class="block lg:hidden p-2 h-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-menu-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <line x1="4" y1="6" x2="20" y2="6"></line>
                <line x1="4" y1="12" x2="20" y2="12"></line>
                <line x1="4" y1="18" x2="20" y2="18"></line>
            </svg>
        </button>
    </div>
    <div class="mt-16 bg-main-background">
        <div class="overflow-hidden">
            <slot/>
        </div>
    </div>
    <div class="bg-main-500 text-white text-center h-auto text-sm p-1 lg:p-4">
        <p>
            <b>ALIMÉNTATE SANAMENTE. LA LECHE MATERNA ES EL MEJOR ALIMENTO PARA LOS BEBÉS Y DEBERÁ CONTINUAR EL MAYOR TIEMPO POSIBLE.</b>
            Consulta a tu profesional de la salud. Estos productos no son un sustituto de la leche materna. Sino un alimento elaborado a base de leche  especialmente desarrollado para niños sanos desde 1 año en adelante. Este producto como la leche de vaca, no ha sido modificado para ser alimento de bebés y no debe ser usado como sustituto de la leche materna. ®Marcas registradas usadas bajo licencia de su titular Societé des Produits Nestlé S.A. Case Postale 352, 1800 Vevey, Suiza. Responsable de la promoción Future Group Developers, S.A. de C.V. con domicilio en Calle Montes Urales 424, Lomas de Chapultepec V Secc., Miguel Hidalgo, 11000, Ciudad de México. Vigencia de la promoción del 01 al 31 de Julio del 2022. *Consulta términos y condiciones, productos participantes, descripción de premios, su cantidad, cobertura geográfica, restricciones y Aviso de Privacidad en <a href="https://www.creciendoyganando.com">www.creciendoyganando.com.</a> *Todos ganan beneficios comerciales. La imagen de la camioneta puede variar de modelos y/o color y solo se muestra con fines de información al consumidor.
        </p>
    </div>

    <div v-show="sidebar" @click.self="closeSidebar()" class="text-white fixed z-20 top-0 w-full h-full bg-black bg-opacity-50">
        <div id="side" class="transform -translate-x-full bg-main-500 w-1/2 h-full transition duration-300 p-2">
            <div class="my-12 flex justify-end">
                <button @click="closeSidebar" class="p-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-bar-to-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="10" y1="12" x2="20" y2="12"></line>
                        <line x1="10" y1="12" x2="14" y2="16"></line>
                        <line x1="10" y1="12" x2="14" y2="8"></line>
                        <line x1="4" y1="4" x2="4" y2="20"></line>
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 gap-y-4 text-center">
                <div class="flex justify-center items-center">
                    <inertia-link :href="route('index')"
                                  :class="route().current('index') ? 'border-white' : 'border-transparent'"
                                  class="transition border-b-2 duration-200 hover:border-white">HOME</inertia-link>
                </div>
                <div class="flex justify-center items-center">
                    <inertia-link :href="route('how_to_participe')"
                                  :class="route().current('how_to_participe') ? 'border-white' : 'border-transparent'"
                                  class="transition border-b-2 duration-200 hover:border-white">CÓMO PARTICIPAR</inertia-link>
                </div>
                <div class="flex justify-center items-center">
                    <inertia-link :href="route('awards')"
                                  :class="route().current('awards') ? 'border-white' : 'border-transparent'"
                                  class="transition border-b-2 duration-200 hover:border-white">PREMIOS</inertia-link>
                </div>
                <div class="flex justify-center items-center">
                    <inertia-link :href="route('participant_products')"
                                  :class="route().current('participant_products') ? 'border-white' : 'border-transparent'"
                                  class="transition border-b-2 duration-200 hover:border-white">PRODUCTOS PARTICIPANTES</inertia-link>
                </div>
                <div class="flex justify-center items-center">
                    <inertia-link :href="route('winners')"
                                  :class="route().current('winners') ? 'border-white' : 'border-transparent'"
                                  class="transition border-b-2 duration-200 hover:border-white">GANADORES</inertia-link>
                </div>
                <div class="flex justify-center items-center">
                    <inertia-link :href="route('contact')"
                                  :class="route().current('contact') ? 'border-white' : 'border-transparent'"
                                  class="transition border-b-2 duration-200 hover:border-white">CONTACTO</inertia-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            sidebar: false
        }
    },
    methods: {
        openSidebar(){
            this.sidebar = true
            let div = document.getElementById('side')
            setTimeout(() => {
                div.classList.remove('-translate-x-full')
                div.classList.add(`translate-x-0`)
            }, 100)
        },
        closeSidebar(){
            let div = document.getElementById('side')
            div.classList.remove(`translate-x-0`)
            div.classList.add('-translate-x-full')
            setTimeout(() => {
                this.sidebar = false
            }, 500)
        }
    }
}
</script>

<style scoped>
.logo-width {
    width: 50%;
}
.nav-shadow {
    box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.75);
    -webkit-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.75);
}
</style>
