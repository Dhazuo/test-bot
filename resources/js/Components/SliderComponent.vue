<template>
    <div class="w-full px-4 hidden lg:block">
        <carousel :items-to-show="1">
            <slide v-for="slideImage in slideImages" :key="slideImage.img">
              <div class="max-w-5xl">
                <img :src="slideImage.img" class="w-full">
              </div>
            </slide>

            <template #addons>
                <navigation/>
                <pagination/>
            </template>
        </carousel>
    </div>
    <div class="w-full px-4 block lg:hidden">
        <carousel :items-to-show="1">
            <slide v-for="slideImage in slideImages" :key="slideImage.img">
                <div class="max-w-5xl">
                    <img :src="slideImage.img_mobile" class="w-full">
                </div>
            </slide>

            <template #addons>
                <navigation/>
                <pagination/>
            </template>
        </carousel>
    </div>
</template>

<script>
import 'vue3-carousel/dist/carousel.css';
import {Carousel, Slide, Pagination, Navigation} from 'vue3-carousel';

export default {
    props: [
        'slideImages'
    ],
    components: {
        Carousel,
        Slide,
        Pagination,
        Navigation,
    },
}
</script>

<style>
.carousel__item {
    min-height: 200px;
    width: 100%;
    background-color: black;
    font-size: 20px;
    border-radius: 8px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.carousel__slide {
    padding: 10px;
}
.carousel__icon {
    fill: #032E4C;
}

.carousel__next {
    top: 50%;
    right: 0;
    transform: translate(100%, -50%);
    background-color: white;
}
.carousel__prev:focus,
.carousel__next:focus {
    box-sizing: content-box;
    background-color: white;
    outline-style: none
}

.carousel__prev:active,
.carousel__next:active {
    background-color: #69BEF9;

}

.carousel__prev {
    top: 50%;
    left: 0;
    transform: translate(-100%, -50%);
    background-color: white;

}

.carousel__pagination-button {
    background-color: white;
}

.carousel__pagination-button--active {
    background-color: #032E4C;

}
</style>
