<template>
    <div>
        <div v-for="post in posts" :key="post.id" class="ma-4">
            <v-card shaped>
                <v-card-title class="headline">{{ post.title }}</v-card-title>

                <span class="autor">
                    <small>{{ 'Autor: ' + post.user.name + ' - ' + formatDate(post.created_at)  }}</small>
                </span>

                <v-card-text>
                    <div v-html="post.description"></div>
                </v-card-text>

                <v-card-actions>
                    <v-textarea
                        outlined
                        label="Insira aqui seu comentário"
                        v-model="description"
                        :disabled="!currentUser"
                    ></v-textarea>

                    <div class="comment ma-4">
                        <v-btn color="success" :disabled="!currentUser" @click="createComment(post)">
                            Comentar
                        </v-btn>
                    </div>
                </v-card-actions>
                
                <div>
                    <h3 class="ml-4">Comentários</h3>
                    
                    <div class="ma-4" v-for="comment in post.comments" :key="comment.id">
                        <v-divider></v-divider>
                        <p class="ml-4 pl-4">{{ comment.description }}</p>
                        <span class="ml-4 pl-4"><small>{{ 'Autor:' + comment.user.name + ' - ' + formatDate(comment.created_at)  }}</small></span>

                        <div class="comment" v-if="comment.user_id == currentUser.id">
                            <v-menu left bottom>
                                <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on">
                                        <v-icon>mdi-dots-vertical</v-icon>
                                    </v-btn>
                                </template>

                                <v-list>
                                    <v-list-item @click="currentComment = comment, modalDelete = true">
                                        <v-list-item-title>Deletar</v-list-item-title>
                                    </v-list-item>
                                </v-list>
                            </v-menu>
                        </div>
                    </div>
                </div>
            </v-card> 

            <v-dialog v-model="modalDelete" persistent max-width="350">
                <v-card>
                    <v-card-title class="headline">Deseja realmente excluir?</v-card-title>
                    <v-card-text>Ao excluir esse comentário não poderá recupera-lo</v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="red darken-1" text @click="modalDelete = false">Cancelar</v-btn>
                        <v-btn color="green darken-1" text @click="deleteComment()">Confirmar</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>               
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts: [],
                modalDelete: false,
                currentComment: null,
                description: null
            }
        },
        created () {            
            this.list()

        },
        computed: {
            currentUser() {
                return this.$store.state.currentUser
            },
        },
        methods: {
            formatDate(date) {
                var data = new Date(date),
                    dia  = data.getDate().toString(),
                    diaF = (dia.length == 1) ? '0'+dia : dia,
                    mes  = (data.getMonth()+1).toString(),
                    mesF = (mes.length == 1) ? '0'+mes : mes,
                    anoF = data.getFullYear();

                return diaF+"/"+mesF+"/"+anoF
            },
            list() {
                axios.get('/api/posts')
                    .then((response) => {
                        console.log(response)
                        this.posts = response.data.posts                        
                    })
            },
            createComment(post) {
                if(!this.currentUser.id && 
                (this.description == null || this.description == '')) {
                    return false
                }

                let payload = {
                    user_id: this.currentUser.id,
                    post_id: post.id,
                    description: this.description
                }

                axios.post('/api/comment/new', payload)
                    .then((response) => {
                        this.description = null
                        this.list()
                    })
            },
            deleteComment() {
                axios.delete('/api/comment/' + this.currentComment.id)
                    .then((response) => {
                        this.currentComment = null
                        this.modalDelete = false
                        this.list()
                    });
            }
        },
    }
</script>

<style lang="scss" scoped>
    .autor {
        display: flex;
        justify-content: center;
    }

    .headline {
        display: flex;
        justify-content: center;
    }

    .v-card__text {
        display: flex;
        justify-content: center;
    }

    .comment {
        display: flex;
        justify-content: flex-end;
    }
</style>