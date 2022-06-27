<template>
    <main-layout>
        <div class="w-full h-full pt-10 relative">
            <div class="hidden opacity-0 lg:block bg-stars st bg-no-repeat absolute w-full h-full top-36 z-1"></div>
            <div class="max-w-xs sm:max-w-lg absolute z-2 -top-32 sm:-top-40 -left-24">
                <img src="/assets/seccion-contacto/nube_1_seccion_contacto.png" alt="" class="cloud-animation">
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-8 container mx-auto">
                <div class="hidden lg:block relative mt-contact">
                    <div class="cloud-animation absolute -bottom-20 -left-32 z-2">
                        <div class="relative w-full h-full">
                            <img src="/assets/seccion-contacto/nube_2_seccion_contacto.png" alt="" class="">
                            <div class="absolute z-0 top-1/2 transform -translate-y-1/2 left-1/2 -translate-x-1/2 max-w-sm">
                                <img src="/assets/seccion-contacto/contacto.jpg" alt="" class="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-full flex lg:block justify-center">
                    <div>
                        <img id="main" src="/assets/creciendo_y_ganando.png" alt="" class="relative z-10">
                    </div>
                </div>
                <div class="block lg:hidden mb-40">
                    <div class="cloud-animation relative w-full h-full">
                        <img src="/assets/seccion-contacto/nube_2_seccion_contacto.png" alt="" class="">
                        <div class="absolute z-0 top-1/2 transform -translate-y-1/2 left-1/2 -translate-x-1/2 max-w-sm">
                            <img src="/assets/seccion-contacto/contacto.jpg" alt="" class="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="max-w-xs sm:max-w-lg absolute z-2 -bottom-48 sm:bottom-contact-2 -right-40">
                <img src="/assets/seccion-contacto/nube_3_seccion_contacto.png" alt="" class="cloud-animation">
            </div>
        </div>
    </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";

export default {
    name: "Contact",
    components: {MainLayout},
    mounted() {
        this.mainLogoAnimation()
        let stars = document.querySelector('.bg-stars')
        setTimeout(() => {
            stars.classList.add('stars')
        }, 500)
    },
    methods: {
        mainLogoAnimation() {
            let image = document.getElementById('main');
            setTimeout(() => {
                image.classList.add('main-animation')
            }, 10)
        },
    }
}
</script>

<style scoped>
.z-1{
    z-index: 1;
}
.z-2 {
    z-index: 2;
}
.st {
    transform: rotate(41deg);
}
</style>
