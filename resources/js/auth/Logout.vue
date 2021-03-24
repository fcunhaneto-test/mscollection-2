<template>
</template>

<script>
export default {
    name: "Logout",
    created() {
        axios.get('/sanctum/csrf-cookie').then(response => {
            axios.post('/api/logout').then(response => {
                console.log('LOGOUT', response.data)
                window.location.href = '/'
            })
        });
    }
}
</script>

<style scoped>

</style>
