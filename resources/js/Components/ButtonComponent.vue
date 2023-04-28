<template>
    <component
        :is="as"
        v-if="!hasSlot"
        type="submit"
        :class="getClass"
        :href="href"
    >
        <icon :icon="icon" :type="color" reverse v-if="icon" :class="label.length > 0 ? 'mr-1' : ''" :size="iconSize"></icon>
        {{ label }}
    </component>
    <div class="w-fit cursor-pointer" v-else>
        <slot></slot>
    </div>
</template>

<script>
import Icon from "./Icon.vue";

export default {
    name: "ButtonComponent",
    components: {Icon},
    props: {
        icon: {
            type: String,
            default: ''
        },
        border: {
            type: Boolean,
            default: false
        },
        round: {
            type: Boolean,
            default: false
        },
        flat: {
            type: Boolean,
            default: false
        },
        label: {
            type: String,
            default: ''
        },
        color: {
            type: String,
            default: 'primary'
        },
        size: {
            type: String,
            default: 'default'
        },
        href: {
            type: String,
            default: ''
        },
        as: {
            type: [String,Object],
            default: 'button'
        }
    },
    data() {
        return {
            colors: {
                primary: {
                    background: 'bg-blue-500 hover:bg-blue-600',
                    backgroundBorder: 'hover:bg-blue-50 border-blue-600',
                    textColor: 'text-white',
                    borderTextColor: 'text-blue-600'
                },
                secondary: {
                    background: 'bg-gray-500 hover:bg-gray-600',
                    backgroundBorder: 'hover:bg-gray-50 border-gray-600',
                    textColor: 'text-white',
                    borderTextColor: 'text-gray-600'
                },
                success: {
                    background: 'bg-green-500 hover:bg-green-600',
                    backgroundBorder: 'hover:bg-green-50 border-green-600',
                    textColor: 'text-white',
                    borderTextColor: 'text-green-600'
                },
                danger: {
                    background: 'bg-red-500 hover:bg-red-600',
                    backgroundBorder: 'hover:bg-red-50 border-red-600',
                    textColor: 'text-white',
                    borderTextColor: 'text-red-600'
                },
                warning: {
                    background: 'bg-yellow-500 hover:bg-yellow-600',
                    backgroundBorder: 'hover:bg-yellow-50 border-yellow-600',
                    textColor: 'text-white',
                    borderTextColor: 'text-yellow-600'

                },
                info: {
                    background: 'bg-purple-500 hover:bg-purple-600',
                    backgroundBorder: 'hover:bg-purple-50 border-purple-600',
                    textColor: 'text-white',
                    borderTextColor: 'text-purple-600'
                },
                dark: {
                    background: 'bg-gray-700 hover:bg-gray-900',
                    backgroundBorder: 'hover:bg-gray-50 border-gray-600',
                    textColor: 'text-white',
                    borderTextColor: 'text-gray-800'
                }
            }
        }
    },
    computed: {
        iconSize() {
          return this.size === 'small' ? 'xs' : this.size === 'default' ? 'default' : 'xl';
        },
        hasSlot() {
            return this.$slots.default !== undefined;
        },
        getClass() {
            let color = this.border || this.flat ? this.colors[this.color].backgroundBorder : this.colors[this.color].background;

            let size = 'py-2.5 px-5'
            switch (this.size) {
                case 'small':
                    if (this.label.length > 0){
                        size = 'py-2 px-4'
                    }else {
                        size = 'py-1 px-3'
                    }
                    break;
                case 'large':
                    size = 'py-3 px-6'
                    break
            }
            let textColor = this.border || this.flat ? this.colors[this.color].borderTextColor : this.colors[this.color].textColor;

            let border = this.border && !this.flat ? 'border' : '';
            let round = this.round ? 'rounded-full' : '';
            let flat = this.flat ? '' : 'hover:shadow-lg'

            return `focus:outline-none ${textColor} text-sm ${size} ${round} ${border} rounded-md ${color} ${flat}`
        }
    }
}
</script>

<style scoped>

</style>
