<template>
    <main-layout>
        <div class="w-full h-full pt-10">
            <div class="max-w-xs sm:max-w-sm absolute top-0 -left-16">
                <img src="/assets/seccion-ganadores/nube_1_seccion_ganadores.png" alt="" class="cloud-animation">
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 container mx-auto px-4">
                <div class="w-full flex justify-center items-center">
                    <div>
                        <img id="main" src="/assets/creciendo_y_ganando.png" alt="" class="w-full lg:w-9/12 mx-auto">

                    </div>
                </div>
                <div class="grid grid-cols-1 gap-y-4 relative z-10">
                    <div>
                        <img src="/assets/seccion-ganadores/ganadores.png" alt="" class="mx-auto">
                    </div>
                    <div v-for="n in 8" class="bg-white h-12 rounded-md w-full">

                    </div>
                </div>
            </div>
            <div class="pt-32">
                <div class="relative">
                    <div class="absolute -left-12 -bottom-20 sm:-bottom-32 lg:-bottom-48 xl:-bottom-60">
                        <img src="/assets/seccion-ganadores/nubes_2_seccion_ganadores.png" alt="" class="cloud-animation">
                    </div>
                </div>
            </div>
        </div>
    </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
export default {
    components: {MainLayout},
    mounted() {
        this.mainLogoAnimation()
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

</style>
