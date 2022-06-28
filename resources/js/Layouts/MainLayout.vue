<template>
    <div class="bg-white text-main-500 text-sm font-extrabold w-full h-16 fixed top-0 z-20 nav-shadow flex items-center justify-between lg:justify-start space-x-8 lg:space-x-4">
        <div class="bg-logo logo-shadow w-full lg:w-1/3 h-full flex items-center justify-center rounded-br-3xl">
            <div class="">
                <img src="/assets/logo_nestle.png" alt="" class="w-10/12 object-contain">
            </div>
        </div>
        <div class="text-center hidden lg:grid grid-cols-6 gap-x-2">
            <div class="flex justify-center items-center">
                <p :href="route('index')"
                              :class="route().current('index') ? 'border-main-500' : 'border-transparent'"
                              class="transition border-b-2 duration-200 hover:border-main-500">HOME
                </p>
            </div>
            <div class="flex justify-center items-center">
                <p :href="route('index')"
                   :class="route().current('index') ? 'border-main-500' : 'border-transparent'"
                   class="transition border-b-2 duration-200 hover:border-main-500">CÓMO PARTICIPAR
                </p>
            </div>
            <div class="flex justify-center items-center">
                <p :href="route('index')"
                   :class="route().current('index') ? 'border-main-500' : 'border-transparent'"
                   class="transition border-b-2 duration-200 hover:border-main-500">PREMIOS
                </p>
            </div>
            <div class="flex justify-center items-center">
                <p :href="route('index')"
                   :class="route().current('index') ? 'border-main-500' : 'border-transparent'"
                   class="transition border-b-2 duration-200 hover:border-main-500">PRODUCTOS PARTICIPANTES
                </p>
            </div>
            <div class="flex justify-center items-center">
                <p :href="route('index')"
                   :class="route().current('index') ? 'border-main-500' : 'border-transparent'"
                   class="transition border-b-2 duration-200 hover:border-main-500">GANADORES
                </p>
            </div>
            <div class="flex justify-center items-center">
                <p :href="route('index')"
                   :class="route().current('index') ? 'border-main-500' : 'border-transparent'"
                   class="transition border-b-2 duration-200 hover:border-main-500">CONTACTO
                </p>
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
    <div class="mt-16 bg-chocolate overflow-hidden">
        <div class="py-10 overflow-hidden">
            <slot />
        </div>
    </div>
    <div class="h-auto p-2 bg-main-500 w-full">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi consectetur deserunt dolores error fugiat, fugit hic minus nam non numquam obcaecati officiis omnis placeat porro, quos rem ut veniam voluptas.
    </div>
</template>

<script>
export default {
    data(){
        return{
            sidebar: false
        }
    },
    methods:{
        openSidebar(){

        }
    }
}
</script>

<style scoped>
.nav-shadow {
    box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.75);
    -webkit-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.75);
    -moz-box-shadow: 0px 1px 4px 0px rgba(0, 0, 0, 0.75);
}
</style>
