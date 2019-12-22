<template>
        <v-content>
            <v-container class="fill-height" fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4" lg="2">
                        <v-card class="elevation-12">
                            <v-card-text>
                                <v-form ref="form">
                                    <v-text-field label="E-mail" name="login" :rules="emailRules"
                                        prepend-icon="mdi-email" type="text" v-model="email" />

                                    <v-text-field id="password" label="Senha" :rules="passwordRules" name="password" @keypress.enter="authenticate"
                                        prepend-icon="mdi-lock" type="password" v-model="password" />
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn class="cyan accent-3" rounded block @click.stop="authenticate()">Entrar</v-btn>
                            </v-card-actions>
                            <div class="register">
                                <span>Não possui login?</span> <a href="javascript:" @click="register"> Registre-se</a>
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
    import { login } from '../helpers/auth';

    export default {
        data() {
            return {
                email: '',
                emailRules: [
                    v => !!v || 'O campo e-mail é obrigatório',
                    v => /.+@.+\..+/.test(v) || 'O campo e-mail é invalido',
                ],
                password: '',
                passwordRules: [
                    v => !!v || 'O campo senha é obrigatório',
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
            register() {
                this.$router.push({ name: 'register' })
            },
            authenticate() {
                if (!this.$refs.form.validate()) {
                    return null
                }
                let payload = {
                    email: this.email,
                    password: this.password
                }
                login(payload)
                    .then((res) => {
                        this.$store.commit("loginSuccess", res);
                        this.$router.push({
                            path: '/'
                        });
                    })
                    .catch((error) => {
                        this.error = "E-mail ou senha inválidos"
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