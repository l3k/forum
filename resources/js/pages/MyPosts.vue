<template>
    <div>
        <v-container>
            <v-text-field
                name="name"
                v-model="title"
                label="Título"
                id="id"
            ></v-text-field>    
            <quill-editor ref="myTextEditor"
                v-model="description"
                :options="editorOption">
            </quill-editor>
            <div class="btn-save">
                <v-btn color="success" @click.stop="save()">Salvar</v-btn>
            </div>
        </v-container>

        <div>
            <div v-for="post in posts" :key="post.id" class="ma-4">
                <v-card shaped>
                    <v-card-title class="headline">
                        <span v-if="!editPost">{{ post.title }}</span>

                        <v-text-field
                            name="name"
                            v-if="editPost && editPost.id == post.id"
                            v-model="editPost.title"
                            label="Título"
                            id="id"
                        ></v-text-field> 
                    </v-card-title>

                    <v-card-text>
                        <div v-html="post.description" v-if="!editPost"></div>
                        <quill-editor ref="myTextEditor" v-if="editPost && editPost.id == post.id"
                            v-model="editPost.description"
                            :options="editorOption">
                        </quill-editor>
                    </v-card-text>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        
                        <v-btn icon @click="editPost = null, list()" v-if="editPost">
                            <v-icon>mdi-close</v-icon>
                        </v-btn>

                        <v-btn icon v-if="editPost" @click="updatePost()">
                            <v-icon>mdi-check</v-icon>
                        </v-btn>

                        <v-btn icon v-if="!editPost" @click="editPost = post">
                            <v-icon>mdi-pencil</v-icon>
                        </v-btn>

                        <v-btn icon v-if="!editPost" @click="modalDelete = true, currentPost = post">
                            <v-icon>mdi-delete</v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-card>                
            </div>
        </div>

        <v-snackbar v-model="snackbar" top :color="typeReturn">
            {{ message }}
            <v-btn text @click="snackbar = false">
                <v-icon>mdi-close</v-icon>
            </v-btn>
        </v-snackbar>

        <v-dialog v-model="modalDelete" persistent max-width="350">
            <v-card>
                <v-card-title class="headline">Deseja realmente excluir?</v-card-title>
                <v-card-text>Ao excluir esse post, os comentário vinculados a ele também serão deletados</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="red darken-1" text @click="modalDelete = false">Cancelar</v-btn>
                    <v-btn color="green darken-1" text @click="deletePost()">Confirmar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        
    </div>
</template>

<script>
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'

    import { quillEditor } from 'vue-quill-editor'
    
    export default {
        components: {
            quillEditor
        },
        data() {
            return {
                title: '',
                description: '',
                editorOption: {
                    modules: {
                        toolbar: [
                            ['bold', 'italic', 'underline', 'strike'],
                            ['blockquote', 'code-block'],
                            [{ 'header': 1 }, { 'header': 2 }],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            [{ 'script': 'sub' }, { 'script': 'super' }],
                            [{ 'indent': '-1' }, { 'indent': '+1' }],
                            [{ 'direction': 'rtl' }],
                            [{ 'size': ['small', false, 'large', 'huge'] }],
                            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                            [{ 'font': [] }],
                            [{ 'color': [] }, { 'background': [] }],
                            [{ 'align': [] }],
                            ['clean'],
                            ['link', 'video']
                        ],
                        syntax: {
                            highlight: text => hljs.highlightAuto(text).value
                        }
                    },
                    placeholder: 'Insira seu texto'
                },
                typeReturn: '',
                message: '',
                posts: [],
                currentPost: null,
                editPost: null,
                snackbar: false,
                modalDelete: false
            }
        },
        created () {
            if(!this.currentUser) {
                this.$router.push({ name: 'login' });
            }
            
            this.list()

        },        
        computed: {
            currentUser() {
                return this.$store.state.currentUser
            },
            editor() {
                return this.$refs.myTextEditor.quill
            },
        },
        methods: {
            save() {
                if(!this.currentUser.id && 
                (this.title == null || this.title == '') && 
                (this.description == null || this.description == '')) {
                    return false
                }

                let payload = {
                    user_id: this.currentUser.id,
                    title: this.title,
                    description: this.description
                }

                axios.post('/api/post/new', payload)
                    .then((response) => {
                        console.log(response)
                        this.typeReturn = 'success'
                        this.message = response.data.message
                        this.snackbar = true
                        this.clear()
                        this.list()
                    })
                    .catch((error) => {
                        this.typeReturn = 'error'
                        this.message = 'Ocorreu um erro ao criar o post, tente novamente mais tarde'
                        this.snackbar = true
                    });
            },
            list() {
                axios.get('/api/' + this.currentUser.id + '/posts')
                    .then((response) => {
                        console.log(response)
                        this.posts = response.data.posts                        
                    })
            },
            clear() {
                this.title = null
                this.description = null
            },
            deletePost() {
                axios.delete('/api/post/' + this.currentPost.id)
                    .then((response) => {
                        this.currentPost = null
                        this.modalDelete = false
                        this.list()
                    })
                    .catch((error) => {
                        this.typeReturn = 'error'
                        this.message = 'Ocorreu um erro ao excluir o post, tente novamente mais tarde'
                        this.snackbar = true
                    });
            },
            updatePost() {
                axios.put('/api/post/edit/' + this.editPost.id, this.editPost)
                    .then((response) => {
                        this.currentPost = null
                        this.modalDelete = false
                        this.list()
                        this.message = response.data.message
                        this.snackbar = true
                        this.typeReturn = 'success'
                        this.editPost = null
                    })
                    .catch((error) => {
                        this.typeReturn = 'error'
                        this.message = 'Ocorreu um erro ao alterar o post, tente novamente mais tarde'
                        this.snackbar = true
                    });
            }
        },
    }
</script>

<style lang="scss" scoped>
    .btn-save {
        display: flex;
        justify-content: center;
        margin-top: 1rem;
    }
    .quill-code {
        border: none;
        height: auto;

        > code {
            width: 100%;
            margin: 0;
            padding: 1rem;
            border: 1px solid #ccc;
            border-top: none;
            border-radius: 0;
            height: 10rem;
            overflow-y: auto;
            resize: vertical;
        }
    }

    .headline {
        display: flex;
        justify-content: center;
    }

    .v-card__text {
        display: flex;
        justify-content: center;
    }
</style>