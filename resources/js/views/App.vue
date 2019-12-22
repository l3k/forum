<template>
    <v-app id="inspire">
        <v-navigation-drawer v-model="drawer" app clipped v-if="currentUser">
            <v-list dense>
                <v-list-item link @click.stop="inicio()">
                    <v-list-item-action>
                        <v-icon>mdi-home-variant</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Inicio</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link @click.stop="perfil()">
                    <v-list-item-action>
                        <v-icon>mdi-account-circle</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Meu perfil</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link @click.stop="myPosts()">
                    <v-list-item-action>
                        <v-icon>mdi-book</v-icon>
                    </v-list-item-action>
                    <v-list-item-content>
                        <v-list-item-title>Meus Posts</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <template v-slot:append>
                <div class="pa-2">
                    <v-btn color="cyan lighten-1" block rounded @click.stop="sair">
                        <v-icon>mdi-exit-to-app</v-icon> Sair
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>

        <v-app-bar app clipped-left>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" v-if="currentUser" class="cyan--text text--accent-3" />
            <v-toolbar-title class="cyan--text text--accent-3">Fórum</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-menu left bottom v-if="!currentUser">
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on">
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item @click="login">
                        <v-list-item-title>Login</v-list-item-title>
                    </v-list-item>

                    <v-list-item @click="register">
                        <v-list-item-title>Registrar</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>

        <v-content transition="slide-x-transition">
            <v-container>
                <router-view></router-view>                
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                drawer: null,
            }
        },
        created() {
            this.$vuetify.theme.dark = true
            
        },
        mounted () {
            console.log(this.currentUser)
        },
        computed: {
            currentUser() {
                return this.$store.state.currentUser
            }
        },
        methods: {
            inicio() {
                this.$router.push({ name: 'home' })
            },
            myPosts() {
                this.$router.push({ name: 'my-posts' })
            },
            perfil() {
                this.$router.push({ name: 'profile' })
            },
            sair() {
                this.$store.commit("logout");
                this.inicio()
            },
            login() {
                this.$router.push({ name: 'login' })
            },
            register() {
                this.$router.push({ name: 'register' })
            },
        },
    }

</script>
