<template>
    <main-layout>
        <div class="w-full h-full pt-10 relative">
            <div class="hidden opacity-0 lg:block bg-stars bg-no-repeat absolute w-full h-full top-36 z-1"></div>

            <div class="max-w-xs sm:max-w-lg absolute -top-36 -right-24">
                <img src="/assets/seccion-productos-participantes/nube_1_seccion_productosparticipantes.png" alt=""
                     class="cloud-animation">
            </div>
            <div class="grid grid-cols-1 gap-y-8 container mx-auto px-4 pb-8">
                <div class="relative z-10 ">
                    <img src="/assets/productos_participantes.png" alt="">
                </div>
                <div class="relative z-10 ">
                    <slider-component :slideImages="images"/>
                </div>
                <div class="relative mt-20 sm:mt-32 lg:mt-44 xl:mt-60">
                    <div class="absolute z-2 -bottom-28 sm:-bottom-44 lg:-bottom-60 xl:-bottom-64 -left-24">
                        <img src="/assets/seccion-productos-participantes/nube_2_seccion_productosparticipantes.png" alt="" class="cloud-animation">
                    </div>
                </div>
            </div>
        </div>
    </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
import SliderComponent from "@/Components/SliderComponent";

export default {
    name: "ParticipantProducts",
    components: {SliderComponent, MainLayout},
    data(){
        return{
            images: [
                {
                    img: '/assets/productos_gerber.png',
                    img_mobile: '/assets/productos_gerber.png'
                }
            ]
        }
    },
    mounted() {
        let stars = document.querySelector('.bg-stars')
        setTimeout(() => {
            stars.classList.add('stars')
        }, 500)
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
</style>
