<template>
    <div class="panel">
        <h4 class="latest-text w3_latest_text">Đánh giá về phim</h4>
        <div v-if="isNotCommented" class="panel-footer">
            <div class="">
                <ul class="rate-area">
                    <input type="radio" id="5-star" v-model="rating" value="5" /><label for="5-star" title="Amazing">5 stars</label>
                    <input type="radio" id="4-star" v-model="rating" value="4" /><label for="4-star" title="Good">4 stars</label>
                    <input type="radio" id="3-star" v-model="rating" value="3" /><label for="3-star" title="Average">3 stars</label>
                    <input type="radio" id="2-star" v-model="rating" value="2" /><label for="2-star" title="Not Good">2 stars</label>
                    <input type="radio" id="1-star" v-model="rating" value="1" /><label for="1-star" title="Bad">1 star</label>
                </ul>
                <textarea id="btn-input" type="text" class="form-control input-sm" placeholder="Mời nhập nội dung..." v-model="body" @keyup.enter="postComment()" autofocus row="5"></textarea>
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
                            <div class="first-div">
                                <strong class="primary-font">{{ comment.user.name }}</strong>
                                <small class="text-muted">
                                    <span class="glyphicon glyphicon-time"></span>{{ comment.diff }} trước
                                </small>
                                <span v-if="comment.updated" class="edit-txt"><i class="fa fa-circle" aria-hidden="true"></i>Đã chỉnh sửa</span>
                                <i v-if="user.id == comment.user.id" class="fa fa-pencil" aria-hidden="true" @click.prevent="editComment()"></i>
                            </div>
                            <div v-if="!isEditCommented || user.id != comment.user.id">
                                <ul class="s-rate-area" v-bind:class="'star-' + comment.id">
                                    <input type="radio" id="show-5-star" value="5" disabled/><label for="show-5-star" title="Amazing">5 stars</label>
                                    <input type="radio" id="show-4-star" value="4" disabled/><label for="show-4-star" title="Good">4 stars</label>
                                    <input type="radio" id="show-3-star" value="3" disabled/><label for="show-3-star" title="Average">3 stars</label>
                                    <input type="radio" id="show-2-star" value="2" disabled/><label for="show-2-star" title="Not Good">2 stars</label>
                                    <input type="radio" id="show-1-star" value="1" disabled/><label for="show-1-star" title="Bad">1 star</label>
                                </ul>
                                <p style="clear:both">
                                    {{ comment.body }}
                                </p>
                            </div>
                        </div>
                        <div v-if="isEditCommented && user.id == comment.user.id" class="panel-footer">
                            <div class="edit-comment">
                                <ul class="rate-area">
                                    <input type="radio" id="5-star" v-model="rating" value="5" /><label for="5-star" title="Amazing">5 stars</label>
                                    <input type="radio" id="4-star" v-model="rating" value="4" /><label for="4-star" title="Good">4 stars</label>
                                    <input type="radio" id="3-star" v-model="rating" value="3" /><label for="3-star" title="Average">3 stars</label>
                                    <input type="radio" id="2-star" v-model="rating" value="2" /><label for="2-star" title="Not Good">2 stars</label>
                                    <input type="radio" id="1-star" v-model="rating" value="1" /><label for="1-star" title="Bad">1 star</label>
                                </ul>
                                <textarea id="btn-input" type="text" class="form-control input-sm" placeholder="Mời nhập nội dung..." v-model="body" @keyup.enter="postComment()" autofocus></textarea>
                                <span class="text-danger error_body"></span>
                                <div class="input-group-btn">
                                    <button class="btn btn-secondary btn-sm" id="btn-chat" @click.prevent="cancel()">
                                    Cancel</button>
                                    <button class="btn btn-warning btn-sm" id="btn-chat" @click.prevent="postComment()">
                                    Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>       
</template>

<script>
    export default {
        props: ['user', 'film', 'asset'],
        data() {
            return {
                viewers: [],
                comments: [],
                body: '',
                rating : 0,
                count: 0,
                message: '',
                isNotCommented : true,
                isEditCommented : false,
                comment : ''
            }
        },
        mounted() {
            this.listen();
            this.getComments();
            this.displayError();
            this.hideError();
        },
        updated() {
            this.ratingStar();
        },
        methods: {
            getComments() {
                axios.get(this.asset + '/api/film/'+ this.film.id +'/comments', {}
                    )
                .then((response) => {
                    this.comments = response.data;
                });
            },
            postComment() {
                axios.post(this.asset + '/api/film/'+ this.film.id +'/comment?api_token=' + this.user.api_token, {
                    body: this.body,
                    rating: this.rating
                })
                .then((response) => {
                    this.hideError();
                    if (!response.data.updated) {
                        this.comments.unshift(response.data);
                        this.count++;
                        $('.count-comment').text(this.count);
                        this.isNotCommented = false;
                    } else {
                        for (var i = 0; i < this.comments.length; i++) {
                            if (this.comments[i].id == response.data.id) {
                                this.comments[i] = response.data;
                            }
                        }
                        this.isEditCommented = false;
                    }
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
            editComment() {
                axios.get(this.asset + '/api/film/'+ this.film.id +'/comment?api_token=' + this.user.api_token, {
                })
                .then((response) => {
                    this.isEditCommented = true;
                    this.comment = response.data;
                }).then((response) => {
                    this.fillingData();
                });
            },
            listen() {
                Echo.join('comment')
                .listen('NewComment', (e) => {
                    if (!e.updated) {
                        this.comments.unshift(e);
                        this.count++;
                        $('.count-comment').text(this.count);
                    } else {
                        for (var i = 0; i < this.comments.length; i++) {
                            if (this.comments[i].id == e.id) {
                                this.comments[i] = e;
                                this.comment = e;
                            }
                        }
                    }
                    this.ratingStar();
                })
            },
            displayError(message) {
                $('.error_body').css({'display' : 'block'});
                $('.error_body').text(message);
            },
            hideError() {
                $('.error_body').css({'display' : 'none'});
                $('.error_body').text('');
            },
            ratingStar() {
                for (var i = 0; i < this.comments.length; i++) {
                    var edit_rating = this.comments[i].rating;
                    var id = this.comments[i].id;
                    $('.star-' + id).find('input[value=' + edit_rating + ']').prop({"checked":true});
                    while (edit_rating < 5) {
                        edit_rating += 1;
                        $('.star-' + id).find('input[value=' + edit_rating + ']').prop({"checked":false});
                    }
                    if (this.comments[i].user.id == this.user.id) {
                        this.isNotCommented = false;
                    }
                }
            },
            fillingData() {
                this.body = this.comment.body;
                this.rating = this.comment.rating;
                var rating = this.comment.rating;
                $('.edit-comment .rate-area').find('input[value=' + rating + ']').prop({"checked":true});
                while (rating < 5) {
                    rating += 1;
                    $('.edit-comment .rate-area').find('input[value=' + rating + ']').prop({"checked":false});
                }
                $('.edit-comment textarea').val(this.comment.body);
            },
            cancel() {
                this.isEditCommented = false;
            }
        }
    }
</script>