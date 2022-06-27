<template>
    <main-layout>
        <div class="grid grid-cols-1 gap-y-8 relative pt-10">
            <div class="grid grid-cols-1 gap-y-10 relative container mx-auto px-4">
                <div class="hidden opacity-0 lg:block bg-stars bg-no-repeat absolute w-full h-full top-0 z-0"></div>
                <div class="w-full mx-auto">
                    <img id="main" src="/assets/creciendo_y_ganando.png" alt="" class="mx-auto">
                </div>
                <div>
                    <img id="participa" src="/assets/participa.png" alt="" class="w-full lg:w-7/12 mx-auto ">
                </div>
            </div>
            <div class="grid grid-cols-1 gap-y-4 container mx-auto px-4">
                <div class="w-full flex justify-center lg:justify-start">
                    <div>
                        <img src="/assets/como_participar.png" alt="">
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-16">
                    <div class="lg:mt-16">
                        <img src="/assets/1_comprar.png" alt="" class="mx-auto">
                    </div>
                    <div class="lg:mt-8">
                        <img src="/assets/2_registrar.png" alt="" class="mx-auto">
                        <div class="text-white relative">
                            <img src="/assets/registra_aqui.png" alt="" class="mx-auto">
                            <div id="hand" class="absolute bottom-0 -right-4 sm:right-36 lg:-right-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="transform -rotate-45" className="icon icon-tabler icon-tabler-hand-click" width=64 height=64 viewBox="0 0 24 24" stroke-width={2} stroke="gray" fill="white" strokeLinecap="round" strokeLinejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M8 13v-8.5a1.5 1.5 0 0 1 3 0v7.5"></path>
                                    <path d="M11 11.5v-2a1.5 1.5 0 0 1 3 0v2.5"></path>
                                    <path d="M14 10.5a1.5 1.5 0 0 1 3 0v1.5"></path>
                                    <path d="M17 11.5a1.5 1.5 0 0 1 3 0v4.5a6 6 0 0 1 -6 6h-2h.208a6 6 0 0 1 -5.012 -2.7l-.196 -.3c-.312 -.479 -1.407 -2.388 -3.286 -5.728a1.5 1.5 0 0 1 .536 -2.022a1.867 1.867 0 0 1 2.28 .28l1.47 1.47"></path>
                                    <path d="M5 3l-1 -1"></path>
                                    <path d="M4 7h-1"></path>
                                    <path d="M14 3l1 -1"></path>
                                    <path d="M15 6h1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="lg:-mt-12">
                        <img src="/assets/3_podras.png" alt="" class="asset-width mx-auto">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-y-4 lg:gap-y-12 px-4">
                <div class="mt-12 container mx-auto">
                    <img src="/assets/solo_registrate.png" alt="" class="mx-auto transform scale-90">
                </div>
                <div class="grid grid-cols-1 gap-y-4 relative">
                    <div class="w-full flex justify-center lg:justify-start container mx-auto">
                        <div>
                            <img src="/assets/premios.png" alt="">
                        </div>
                    </div>
                    <div class="w-full container mx-auto">
                        <div class="hidden lg:block absolute w-full h-full lg:top-16 xl:top-14 -right-32 z-0">
                            <img src="/assets/nubes_premios.png" alt="" class="object-cover cloud-animation">
                        </div>
                        <div class="block lg:hidden absolute w-full h-full top-28 -right-12 z-0">
                            <img src="/assets/nubes_premios.png" alt="" class="object-cover cloud-animation">
                        </div>
                        <img src="/assets/imagen_premios.png" alt="" class="asset-width mx-auto relative z-10">
                    </div>
                </div>
                <div class="mt-8">
                    <img src="/assets/participa_para_ganar.png" alt="" class="transform scale-90 mx-auto">
                </div>
            </div>
            <div class="grid grid-cols-1 gap-y-4 relative z-10 container mx-auto px-4 pb-40">
                <div class="hidden lg:block bg-stars bg-no-repeat absolute w-full h-full top-0 z-0"></div>
                <div>
                    <img src="/assets/productos_participantes.png" alt="" class="transform scale-90 mx-auto">
                </div>
                <div class="relative z-10">
                    <slider-component :slideImages="images" />
                </div>
            </div>
            <div class="absolute bottom-mobile sm:bottom-tablet lg:bottom-lg xl:bottom-xl">
                <img src="/assets/seccion-productos-participantes/nube_2_seccion_productosparticipantes.png" alt="" class="cloud-animation">
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
            handPosition: null,
            images: [
                {
                    img: '/assets/productos_gerber.png',
                    img_mobile: '/assets/productos_gerber.png'
                }
            ]
        }
    },
    mounted() {
        this.animations()
        window.addEventListener('scroll', this.watching)
    },
     beforeUnmount() {
       window.removeEventListener('scroll', this.watching)
     },
    methods: {
        animations() {
            this.mainLogoAnimation()
            let stars = document.querySelector('.bg-stars')
            setTimeout(() => {
                stars.classList.add('stars')
            }, 500)
            let image = document.getElementById('participa')
            setTimeout(() => {
                image.classList.add('cloud-animation')
            }, 2500)
        },
        mainLogoAnimation() {
            let image = document.getElementById('main');
            setTimeout(() => {
                image.classList.add('main-animation')
            }, 10)
        },
        watching() {
            let hand = document.getElementById('hand')
            let position = hand.getBoundingClientRect().top
            this.handPosition = position
        }
    },
    watch: {
        'handPosition': function () {
            if (this.handPosition > 500 && this.handPosition < 530) {
                let hand = document.getElementById('hand')
                hand.classList.add('hand-animation')
                window.removeEventListener('scroll', this.watching)
                setTimeout(() => {
                    hand.classList.add('opacity-0')
                }, 3000)
            }
        }
    }
}
</script>

<style scoped>
    .asset-width {
        width: 70%;
    }
    .asset-bottom {
        bottom: -30rem;
    }

    .hand-animation {
        transition: .5s ease-in;
        animation: hand-keyframe ease 3s;
    }

    @keyframes hand-keyframe {
        10% {
            transform: translate(-8px, -8px);
        }
        25% {
            transform: translate(0, 0);
        }
        35% {
            transform: translate(-8px, -8px);
        }
        50% {
            transform: translate(0, 0);
        }
        60% {
            transform: translate(-8px, -8px);
        }
        75% {
            transform: translate(0, 0);
        }
        85% {
            transform: translate(-8px, -8px);
        }
        95% {
            transform: translate(0, 0);
        }
    }
</style>
