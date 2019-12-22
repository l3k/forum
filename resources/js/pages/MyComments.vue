<template>
    <div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        created () {
            if(!this.currentUser) {
                this.$router.push({ name: 'login' });
            }
        },
        computed: {
            currentUser() {
                return this.$store.state.currentUser
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>