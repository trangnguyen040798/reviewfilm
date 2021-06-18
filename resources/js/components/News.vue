<template>
    <div class="panel">
         <h3>Bình Luận</h3>
        <div class="panel-footer">
            <div class="">
                <textarea id="btn-input" type="text" class="form-control input-sm" placeholder="Mời nhập nội dung..." v-model="body" @keyup.enter="postComment()" autofocus ></textarea>
                <span class="text-danger error_body"></span>
                <div class="input-group-btn">
                    <button class="btn btn-warning btn-sm" id="btn-chat" @click.prevent="postComment()">
                    Send</button>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <ul class="chat">
                <li class="left clearfix" v-for="comment in comments">
                    <span class="chat-img pull-left">
                        <img v-bind:src="comment.path_image + comment.user.image" alt="User Avatar" class="img-circle" />
                    </span>
                    <div class="chat-body clearfix">
                        <div class="header">
                            <strong class="primary-font">{{ comment.user.name }}</strong> <small class="text-muted">
                                <span class="glyphicon glyphicon-time"></span>{{ comment.diff }} trước</small>
                            </div>
                            <p>
                                {{ comment.body }}
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>       
</template>

<script>
    export default {
        props: ['user', 'news', 'asset'],
        data() {
            return {
                viewers: [],
                comments: [],
                body: '',
                count: 0,
                message: ''
            }
        },
        mounted() {
            this.listen();
            this.getComments();
            this.displayError();
            this.hideError();
        },
        methods: {
            getComments() {
                axios.get(this.asset + '/api/news/'+ this.news.id +'/comments', {}
                    )
                .then((response) => {
                    this.comments = response.data;
                });
            },
            postComment() {
                axios.post(this.asset + '/api/news/'+ this.news.id +'/comment?api_token=' + this.user.api_token, {
                    body: this.body
                })
                .then((response) => {
                    this.body = '';
                    this.comments.unshift(response.data);
                    this.hideError();
                    this.count++;
                    $('.count-comment').text(this.count);
                }).catch((error) => {
                    if (error.request) {
                        if (error.message == 'Request failed with status code 401') {
                            this.message = 'Vui lòng đăng nhập để đánh giá';
                        } else {
                            this.message = error.message;
                        }
                        this.displayError(this.message);
                    }
                    if (error.response) {
                        this.displayError(error.response.data.errors.body[0]);
                    }
                });
            },
            listen() {
                Echo.join('comment')
                .here((users) => {
                    this.count = this.comments.length;
                })
                .listen('NewComment', (e) => {
                    this.comments.unshift(e);
                });
            },
            displayError(message) {
                $('.error_body').css({'display' : 'block'});
                
                $('.error_body').text(message);
            },
            hideError() {
                $('.error_body').css({'display' : 'none'});
                $('.error_body').text('');
            }
        }
    }
</script>