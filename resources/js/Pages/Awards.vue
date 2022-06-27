<template>
    <main-layout>
        <div class="w-full h-full pt-10 relative">
            <div class="max-w-xs sm:max-w-lg absolute -top-20 -right-24">
                <img src="/assets/seccion-premios/nube_1_seccion_premios.png" alt="" class="cloud-animation">
            </div>
            <div class="hidden opacity-0 lg:block bg-stars bg-no-repeat absolute w-full h-full top-36 z-0"></div>
            <div class="grid grid-cols-1 gap-y-8 container mx-auto px-4 relative z-10 pb-8">
                <div class="grid grid-cols-1 gap-y-2">
                    <div class="flex justify-center lg:justify-start">
                        <div>
                            <img src="/assets/premios.png" alt="">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                        <div class="col-span-2">
                            <img src="/assets/seccion-premios/camioneta.png" alt="">
                        </div>
                        <div class="flex items-center justify-center">
                            <div>
                                <img src="/assets/seccion-premios/gana_hasta.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="flex justify-center lg:justify-end items-center">
                        <div>
                            <img src="/assets/seccion-premios/otros_premios.png" alt="">

                        </div>
                    </div>
                    <div class="flex items-center">
                        <div>
                            <img src="/assets/seccion-premios/premios.png" alt="" class="lg:-mt-20">

                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute -left-12 -bottom-24 sm:-bottom-48 lg:-bottom-56 xl:-bottom-72">
                <img src="/assets/seccion-premios/nubes_2_seccion_premios.png" alt="" class="cloud-animation">
            </div>
        </div>
    </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
export default {
    components: {MainLayout},
    mounted() {
        let stars = document.querySelector('.bg-stars')
        setTimeout(() => {
            stars.classList.add('stars')
        }, 500)
    }
}
</script>

<style scoped>

</style>
