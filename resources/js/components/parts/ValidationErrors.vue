<template>
    <div>
        <ul class="alert alert-danger pl-5" role="alert">
            <li v-for="(value, index) in validationErrors" :key="index">
                {{ value }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        errors: Object
    }, // :errors
    computed: {
        validationErrors() {
            let errors = Object.values(this.errors)
            errors = errors.flat()

            return errors
        }
    },
    methods: {

    }
}
</script>
