<template>
    <div>
        <h1>All records</h1>

        <div v-if="errored" class="alert alert-danger" role="alert">
            Records was not loads. Try again.
        </div>

        <table v-else class="table table-striped">
            <div v-if="loading">Loading...</div>
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
                    <button class="btn btn-success">Edit</button>
                    <button class="btn btn-danger">Delete</button>
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
            post_id: '',
            pagination: {},
            edit: false,
            loading: true,
            errored: false
        }
    },
    mounted() {
        this.getPosts()
    },
    methods: {
        getPosts(page_url) {
            page_url = page_url || '/api/posts'

            axios
                .get(page_url)
                .then(response => {
                    this.posts = response.data.data
                    this.makePagination(response.data)
                })
                .catch(error => {
                    console.log(error)
                    this.errored = true
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
        }
    }
}
</script>
