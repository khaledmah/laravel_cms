<template>
    <li class="shopcart">
        <a class="cartbox_active" href="#">
        <span class="product_qun" v-if="unreadcount > 0">{{unreadcount}}</span></a>
                                <!-- Start Shopping Cart -->
                                <div class="block-minicart minicart__active">
                                    <div class="minicart-content-wrapper" v-if="unreadcount > 0">
                                        <div class="single__items">
                                            <div class="miniproduct">
                                                <div class="item01 d-flex md--20" v-for="item in unread" :key="item.id">
                                                    <div class="thumb">
                                                        <a :href="`/edit-comment/${item.data.id}`" @click="readNotification(item)"><img src="/frontend/images/product/sm-img/1.jpg" alt="`${item.data.post_title}`"></a>
                                                    </div>
                                                    <div class="content">
                                                        <h6><a :href="`/edit-comment/${item.data.id}`" @click="readNotification(item)">you have new comment in post : {{item.data.post_title}}</a></h6>
                                                        <span class="prize">{{item.data.created_at}}</span>
                                                        
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <!-- End Shopping Cart -->
                            </li>
</template>

<script>
    export default {
        data:function () {
            return {
                read: {},
                unread: {},
                unreadcount :0,
            }
        },
        created: function(){

            this.getNotification();

            let userId=$('meta[name="userId"]').attr('content');
            
            Echo.private('App.User.' + userId)
                 .notification((notification) => {
                    alert(notification.type);
                  this.unread.unshift(notification);
                  this.unreadcount++;
    });
        },
        methods: {
            getNotification(){
                axios.get('/user/notification/get').then(res=>{
                    this.unread=res.data.unread;
                    this.read=res.data.read;
                    this.unreadcount=res.data.unread.length;

                }).catch(error => Exception.handel(error));
            },
             readNotification(notification){
                axios.post('/user/notification/read',{id: notification.id}).then(res=>{
                    this.unread.splice(notification,1);
                    this.read.push(notification);
                    this.unreadcount--;

                }).catch(error => Exception.handel(error));
            },

        },
    }
</script>
