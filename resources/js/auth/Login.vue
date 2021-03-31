<template>
    <div class="container mt-6">
        <div class="columns is-centered">
            <div class="column is-three-fifths mt-6">
                <div class="card is-bordered py-4 px-4">
                    <div class="card-header">
                        <h1 class="title is-4 has-text-black">Login</h1>
                    </div>
                    <div class="card-content">
                        <div v-if="!fail">
                            <div class="field">
                                <label for="email" class="label">Email</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input id="email" type="email" v-model="email" class="input" aria-required="true">
                                    <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                                </div>
                                <p v-if="errors.email" class="help is-danger">{{ errors.email[0] }}</p>
                            </div>
                            <div class="field mt-4">
                                <label for="password" class="label">Senha</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input id="password" type="password" v-model="password" class="input"
                                           aria-required="true" @keyup.enter="login">
                                    <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                                </div>
                                <p v-if="errors.password" class="help is-danger">{{ errors.password[0] }}</p>
                            </div>
                            <div class="field has-text-centered mt-4">
                                <button class="button is-success" @click="login">ENVIAR</button>
                            </div>
                        </div>
                        <div v-else>
                            <h2 class="title is-2">Acesso Negado</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data() {
        return {
            email: "",
            password: "",
            fail: false,
            errors: []
        };
    },
    methods: {
        login() {
            axios.get('/sanctum/csrf-cookie').then(response => {
                axios.post('/api/login', {
                    email: this.email,
                    password: this.password
                }).then(response => {
                    window.location.href = '/'
                }).catch(errors => {
                    console.log(errors.response)
                    this.fail = true
                })
            }).catch(errors => console.log(errors))
        }
    }
}
</script>

<style scoped>

</style>
