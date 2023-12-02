<template>
    <div v-if="this.article" 
        class="alert alert-primary" role="alert">
        Добавлена новый комментарий к статье 
        <strong>
            <a :href="`/articles/${this.article.id}/`">
                {{this.article.name}}
            </a>
        </strong>
    </div>
</template>  

<script>
    export default {
    data() { 
        return { 
            msg: null,
            article: null,
            comment: null,
            comment_url: null,
        } 
    },
    created() {
        window.Echo.channel('comments_channel').listen('EventNewComment', (data) => {
            console.log("Добавлен комментарий", data)
            this.article = data.article;
            this.comment = data.comment;
            // alert('Добавлена новая статья!');
        })
    },
    }
</script>
