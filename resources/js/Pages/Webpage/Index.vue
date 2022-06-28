<template>
    <main-layout>
        <div class="w-full grid grid-cols-1 gap-y-16">
            <div
                class="w-full container mx-auto px-4 ">
                <div class="mx-auto max-w-xl">
                    <img id="main" src="/assets/esta_de_vuelta.png" alt=""
                         class="mx-auto transform scale-0 origin-center ">
                </div>
                <div class="mx-auto max-w-xs">
                    <img id="main-2" src="/assets/calcula.png" alt="" class="mx-auto transform scale-0 origin-center ">
                </div>
            </div>
            <div class="relative">
                <div
                    class="hidden lg:block bg-logo border-2 border-main-900 shadow-xl rounded-md absolute top-0 right-0 px-8 py-2 flex items-center">
                    <div class="max-w-sm pr-24">
                        <img src="/assets/como_participar.png" alt="" class="">
                    </div>
                </div>
                <div id="steps" class="container mx-auto px-4 grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-0 ">
                    <div
                        class="block lg:hidden bg-logo border-2 border-main-900 shadow-xl rounded-md px-8 py-2 flex items-center">
                        <div class="max-w-sm">
                            <img src="/assets/como_participar.png" alt="" class="">
                        </div>
                    </div>
                    <div class="flex justify-center lg:justify-end">
                        <div class="max-w-xs">
                            <img id="step-1" src="/assets/1_compra.png" alt="" class="step-1 mx-auto">
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <div id="step-2" class="step-2 max-w-xs lg:mt-48">
                            <img src="/assets/2_registra.png" alt="" class="mx-auto">
                            <inertia-link as="button" class="transition duration-200 transform active:scale-90">
                                <img src="/assets/boton_registra_aqui.png" alt="" class="mx-auto">
                            </inertia-link>
                            <inertia-link as="button" class="transition duration-200 transform active:scale-90">
                                <img src="/assets/boton_consulta_tu_canal.png" alt="" class="mx-auto">
                            </inertia-link>
                        </div>
                    </div>
                    <div class="flex justify-center lg:justify-start">
                        <div class="max-w-xs lg:mt-96">
                            <img id="step-3" src="/assets/3_cuenta.png" alt="" class="step-3 mx-auto">
                        </div>
                    </div>
                </div>

            </div>
            <div class="relative">
                <div
                    class="hidden lg:block bg-logo border-2 border-main-900 shadow-xl rounded-md absolute top-0 left-0 px-8 py-2 flex items-center">
                    <div class="max-w-sm pl-24">
                        <img src="/assets/premios.png" alt="" class="">
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-y-8 lg:gap-12 container mx-auto px-4">
                    <div
                        class="block lg:hidden bg-logo border-2 border-main-900 shadow-xl rounded-md px-8 py-2 flex items-center justify-center">
                        <div class="max-w-sm">
                            <img src="/assets/premios.png" alt="" class="">
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex justify-center">
                            <div class="max-w-sm">
                                <img src="/assets/motos.png" alt="" class="mx-auto">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-y-4">
                        <div class="flex justify-center">
                            <div class="max-w-sm">
                                <img src="/assets/celulares.png" alt="" class="mx-auto">
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <div class="max-w-sm">
                                <img src="/assets/basculas.png" alt="" class="mx-auto">
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <div class="max-w-sm">
                                <img src="/assets/maquinas_contadoras.png" alt="" class="mx-auto">
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="grid grid-cols-1 gap-y-4">
                            <div class="flex justify-center">
                                <div class="max-w-sm">
                                    <img src="/assets/laptops.png" alt="" class="mx-auto">
                                </div>
                            </div>
                            <div class="flex justify-center">
                                <div class="max-w-sm">
                                    <img src="/assets/tablets.png" alt="" class="mx-auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="container mx-auto px-4 mt-16">
                    <slider-component :slideImages="images"></slider-component>
                </div>
            </div>
        </div>
    </main-layout>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";
import SliderComponent from "@/Components/SliderComponent";

export default {
    components: {SliderComponent, MainLayout},
    data() {
        return {
            images: [
                {
                    img: '/assets/carlos_v.png',
                    img_mobile: '/assets/carlos_v.png',
                },
                {
                    img: '/assets/crunch.png',
                    img_mobile: '/assets/crunch.png',
                },
                {
                    img: '/assets/kit_kat.png',
                    img_mobile: '/assets/kit_kat.png',
                },
                {
                    img: '/assets/larin.png',
                    img_mobile: '/assets/larin.png',
                },
            ],
            steps_position: null,
            steps_position_mobile: null,
            animation_status: false
        }
    },
    mounted() {
        let step_div = document.getElementById('steps')
        let step_div_position = step_div.getBoundingClientRect().top
        console.log(step_div_position)
        window.addEventListener('scroll', this.watching)
        window.addEventListener('touchmove', this.watching_mobile)

        let main = document.getElementById('main')
        let main_2 = document.getElementById('main-2')

        setTimeout(() => {
            main.classList.remove('scale-0')
            main.classList.add('grow')
            main_2.classList.remove('scale-0')
            main_2.classList.add('grow')
        }, 500)

    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.watching)
        window.removeEventListener('touchmove', this.watching_mobile)
    },
    methods: {
        watching() {
            let step_div = document.getElementById('steps')
            let step_div_position = step_div.getBoundingClientRect().top
            this.steps_position = step_div_position
        },
        watching_mobile() {
            let step_div = document.getElementById('steps')
            let step_div_position = step_div.getBoundingClientRect().top
            this.steps_position_mobile = step_div_position
        }
    },
    watch: {
        'steps_position': function () {
            if (!this.animation_status) {
                if ((this.steps_position > 500 && this.steps_position < 550) || this.steps_position < 0) {
                    let step_1 = document.getElementById('step-1')
                    let step_2 = document.getElementById('step-2')
                    let step_3 = document.getElementById('step-3')
                    step_1.classList.add('step-animation')
                    setTimeout(() => {
                        step_2.classList.add('step-animation')
                    }, 350)
                    setTimeout(() => {
                        step_3.classList.add('step-animation')
                    }, 700)
                    this.animation_status = true
                    window.removeEventListener('scroll', this.watching)

                }
            }
        },
        'steps_position_mobile': function () {
            if (!this.animation_status) {
                if (this.steps_position < 150) {
                    let step_1 = document.getElementById('step-1')
                    let step_2 = document.getElementById('step-2')
                    let step_3 = document.getElementById('step-3')
                    step_1.classList.add('step-animation')
                    setTimeout(() => {
                        step_2.classList.add('step-animation')
                    }, 350)
                    setTimeout(() => {
                        step_3.classList.add('step-animation')
                    }, 700)
                    this.animation_status = true
                    window.removeEventListener('touchmove', this.watching_mobile)

                }
            }
        }
    }
}
</script>

<style scoped>

.grow {
    animation: growing ease-in 1.7s forwards;

}

.step-1, .step-2, .step-3 {
    transform: scale(1.2);
    opacity: 0;
}

.step-animation {
    animation: steps .5s ease-in forwards;
}

@keyframes steps {
    50% {
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes growing {
    10% {
        transform: scale(1.3);
    }
    20% {
        transform: scale(.8);
    }
    30% {
        transform: scale(1.2);
    }
    35% {
        transform: scale(.9);
    }
    40% {
        transform: scale(1.1);
    }
    45% {
        transform: scale(1);
    }
}
</style>
