<template>
    <i :class="getClass"></i>
</template>

<script>

export default {
    name: "Icon",
    props: {
        icon: {
            type: String
        },
        size: {
            type: String,
            default: 'default'
        },
        type: {
            type: String,
            default: 'default'
        },
        reverse: {
            type: Boolean,
            default: false
        }
    },
    data() {
        return {
            sizes: {
                'xs': 'text-xs',
                'sm': 'text-sm',
                'default': 'text-base',
                'lg': 'text-lg',
                'xl': 'text-xl',
                '2xl': 'text-2xl',
                '3xl': 'text-3xl',
                '5xl': 'text-5xl',
                '8xl': 'text-8xl',
            },
        }
    },
    computed: {
        getClass() {
            return `${this.icon} ${this.sizes[this.size]} cursor-pointer bg-transparent`;
        }
    }
}
</script>

<style scoped>

</style>
