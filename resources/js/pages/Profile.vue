<template>
    <div>
        <v-container class="fill-height" fluid>
            <v-row align="center" justify="center">
                <v-col cols="12" sm="8" md="8">
                <v-card color="#385F73" dark >
                    <v-card-title class="headline">Alterar meus dados</v-card-title>
                    
                    <v-card-text>
                        <v-form ref="form">
                            <v-text-field label="Nome" name="login" :rules="nameRules"
                                prepend-icon="mdi-account" type="text" v-model="name" />

                            <v-text-field label="E-mail" name="login" :rules="emailRules"
                                prepend-icon="mdi-email" type="text" v-model="email" />

                            <v-text-field id="password" label="Senha" name="password"
                                prepend-icon="mdi-lock" type="password" v-model="password" />
                        </v-form>
                    </v-card-text>

                    <v-card-actions>
                        <v-btn color="primary" @click.stop="updateProfile()">Salvar</v-btn>
                    </v-card-actions>
                </v-card>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>

    export default {
        data() {
            return {                
                name: null,
                nameRules: [
                    v => !!v || 'O campo nome é obrigatório',
                ],
                email: null,
                emailRules: [
                    v => !!v || 'O campo e-mail é obrigatório',
                    v => /.+@.+\..+/.test(v) || 'O campo e-mail é invalido',
                ],
                password: null,
                error: '',
                snackbar: false
            }
        },
        computed: {
            currentUser() {
                return this.$store.state.currentUser
            }
        },
        created () {
            if(!this.currentUser) {
                this.$router.push({ name: 'login' });
            }

            this.name = this.currentUser.name
            this.email = this.currentUser.email
        },
        computed: {
            currentUser() {
                return this.$store.state.currentUser
            }
        },
        methods: {
            updateProfile() {    
                console.log(this.currentUser)            
                let payload = {
                    id: this.currentUser.id,
                    name: this.name,
                    email: this.email,
                    password: this.password,
                }
                
                axios.put('/api/' + payload.id + '/update', payload)
                    .then((response) => {
                        let user = Object.assign({}, response.data.user, {token: this.currentUser.token});
                        localStorage.setItem("user", JSON.stringify(user));
                    })
                    .catch((error) => {
                        this.error = "Ocorreu um erro ao atualizar o perfil"
                        this.snackbar = true
                    });
                
                this.password = ''
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>