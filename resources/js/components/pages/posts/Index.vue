<template>
    <div>
        <h1>All records</h1>

        <div class="row mb-3">
            <div class="col-3"></div>
            <div class="col-6">
                <form @submit.prevent="addPost">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input v-model="post.title" type="text" class="form-control" id="title" placeholder="Title goes here...">
                    </div>
                    <div class="form-group">
                        <label for="descr">Text</label>
                        <textarea v-model="post.descr" class="form-control" id="descr" rows="3" placeholder="Description goes here..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                    <button v-if="edit" @click="editCancel" type="button" class="btn btn-primary float-right">Cancel</button>
                </form>
            </div>
            <div class="col-3"></div>
        </div>

        <div v-if="errored" class="alert alert-danger" role="alert">
            Records was not loads. Try again.
        </div>

        <div v-for=" (message, index) in messages" class="alert alert-success" role="alert">
            {{ message }}
            <i @click.prevent="clearMessage(index)" class="btn float-right text-dark fa fa-times p-0"></i>
        </div>

        <validation-errors v-if="validationErrors" :errors="validationErrors"></validation-errors>

        <div v-if="loading" class="alert alert-warning" role="alert">
            Loading...
        </div>
        <table v-else class="table table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Descr</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="post in posts" :key="post.id">
                <th scope="row">{{ post.id }}</th>
                <td>{{ post.title }}</td>
                <td>{{ post.descr }}</td>
                <td>
                    <button @click="editPost(post)" class="btn btn-success"><i class="far fa-edit"></i></button>
                    <button @click="deletePost(post.id)" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                </td>
            </tr>
            </tbody>
        </table>

        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-for="link in pagination.links"
                    :class="{ active: link.active, disabled: !link.url }"
                    @click.prevent="getPosts(link.url)"
                    class="page-item"><a class="page-link" href="#">
                    <span v-html="link.label"></span>
                </a></li>
            </ul>
        </nav>

    </div>
</template>

<script>
export default {
    data() {
        return {
            posts: [],
            post: {
                id: '',
                title: '',
                descr: ''
            },
            pagination: {},
            edit: false,
            loading: true,
            errored: false,
            messages: [],
            validationErrors: ''
        }
    },
    mounted() {
        this.getPosts()
    },
    methods: {
        getPosts(page_url) {
            page_url = page_url || '/api/posts'
            axios
                .get(page_url) // method GET
                .then(response => {
                    this.posts = response.data.data
                    this.makePagination(response.data)
                })
                .catch(error => {
                    console.log(error.response)
                    this.errored = true;
                })
                .finally(() => this.loading = false)
        },
        makePagination(response) {
            let pagination = {
                current_page: response.current_page,
                last_page: response.last_page,
                prev_page_url: response.prev_page_url,
                next_page_url: response.next_page_url,
                links: response.links
            }

            this.pagination = pagination
        },
        deletePost(id) {
            axios
            .delete(`/api/posts/${id}`) // method DELETE
            .then(response => {
                this.getPosts()
                this.pushMessage(response.data.message)
                console.log(response)
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
        },
        addPost() {
            if (this.edit === false) {
                // add the post
                axios
                .post('/api/posts', {
                    title: this.post.title,
                    descr: this.post.descr
                })
                .then(response => {
                    this.editCancel()
                    this.getPosts()
                    this.pushMessage(response.data.message)
                    console.log(response)
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.validationErrors = error.response.data.errors
                    }
                    console.log(error.response)
                })
            } else {
                // edit the post
                axios
                    .put(`/api/posts/${this.post.id}`, {
                        title: this.post.title,
                        descr: this.post.descr
                    })
                    .then(response => {
                        this.editCancel()
                        this.getPosts()
                        this.pushMessage(response.data.message)
                        console.log(response)
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.validationErrors = error.response.data.errors
                        }
                        console.log(error)
                    })
            }
        },
        editPost(post) {
            this.edit = true
            this.post.id = post.id
            this.post.title = post.title
            this.post.descr = post.descr
        },
        editCancel(){
            this.edit = false
            this.id = ''
            this.title = ''
            this.descr = ''
        },
        pushMessage(message) {
            this.messages.push(message)
        },
        clearMessage(index) {
            this.messages.splice(index, 1)
        }
    }
}
</script>
