<template>
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4" lg="2">
                        <v-card class="elevation-12">
                            <v-card-text>
                                <v-form ref="form">
                                    <v-text-field label="Nome" name="login" :rules="nameRules"
                                        prepend-icon="mdi-account" type="text" v-model="name" />

                                    <v-text-field label="E-mail" name="login" :rules="emailRules"
                                        prepend-icon="mdi-email" type="text" v-model="email" />

                                    <v-text-field id="password" label="Senha" :rules="passwordRules" name="password"
                                        prepend-icon="mdi-lock" type="password" v-model="password" />

                                    <v-text-field id="password" label="Confirmar senha" :rules="cPasswordRules" name="password" 
                                        prepend-icon="mdi-lock" type="password" v-model="password_confirmation" />
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn class="primary" rounded block @click.stop="register()">Registrar</v-btn>
                            </v-card-actions>
                            <div class="register">
                                <span>Já possui uma conta?</span> <a href="javascript:" @click="login"> Login</a>
                            </div>
                        </v-card>

                        <v-snackbar v-model="snackbar" top color="error">
                            {{ error }}
                            <v-btn text @click="snackbar = false">
                                <v-icon>mdi-close</v-icon>
                            </v-btn>
                        </v-snackbar>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
</template>

<script>
    import { register } from '../helpers/auth';

    export default {
        data() {
            return {
                name: '',
                nameRules: [
                    v => !!v || 'O campo nome é obrigatório',
                ],
                email: '',
                emailRules: [
                    v => !!v || 'O campo e-mail é obrigatório',
                    v => /.+@.+\..+/.test(v) || 'O campo e-mail é invalido',
                ],
                password: '',
                passwordRules: [
                    v => !!v || 'O campo senha é obrigatório',
                ],
                password_confirmation: '',
                cPasswordRules: [
                    v => !!v || 'O campo e-mail é obrigatório',
                    v => !!(this.password === this.password_confirmation) || 'O campo de confirmar senha deve ser igual a o campo senha'
                ],
                error: '',
                snackbar: false
            }
        },
        created () {
            if(this.currentUser) {
                this.$router.push({ name: 'home' });
            }
        },
        computed: {
            currentUser() {
                return this.$store.state.currentUser
            }
        },
        methods: {
            login() {
                this.$router.push({ name: 'login' })
            },

            register() {
                if (!this.$refs.form.validate()) {
                    return null
                }
                let payload = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                }
                register(payload)
                    .then((res) => {
                        this.$store.commit("loginSuccess", res);
                        this.$router.go(this.$router.push({path: '/'}));
                    })
                    .catch((error) => {
                        let errors = Object.values(error);
                        errors = errors.flat();
                        this.error = errors.toString()

                        this.snackbar = true
                    });
            }
        },
    };

</script>

<style scoped>
    .register {
        display: flex;
        padding: 1rem;
        justify-content: space-around;
        align-items: center;
    }
</style>