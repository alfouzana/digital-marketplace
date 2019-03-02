<template>
    <div class="modal" tabindex="-1" role="dialog" v-if="item"
         style="
            display: block;
            background: rgba(150, 150, 150, .5);
            overflow: auto;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        #{{ item.id }}
                    </h5>
                    <button type="button" class="close"
                            @click="$emit('close')"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <h3>{{ item.title }}</h3>

                    <img :src="item.cover_url" 
                         class="img-thumbnail w-100 mb-2"></img>

                    <div class="product-admin-attributes-bar mb-2">
                        <!-- todo: i18n -->
                        <a :href="item.sample_url">
                            <i class="fa fa-download"></i> 
                            Sample
                        </a>

                        <!-- todo: i18n -->
                        <a href="#">
                            <i class="fa fa-download"></i> 
                            File
                        </a>

                        <span>
                            <i class="fa fa-dollar-sign"></i>
                            {{ item.price }}
                        </span>

                        <span>
                            <i class="fa fa-folder"></i> 
                            {{ item.category }}
                        </span>

                        <span>
                            <i class="fa fa-user-circle"></i>
                            {{ item.user }}
                        </span>

                        <span>
                            <i class="fa fa-plus-square"></i>
                            {{ item.created_at }}
                        </span>

                        <span>
                            <i class="fa fa-edit"></i>
                            {{ item.updated_at }}
                        </span>
    
                        <span v-if="item.delted_at">
                            <i class="fa fa-archive"></i>
                            {{ item.deleted_at }}
                        </span>

                        <span v-if="item.approval_at">
                            <i class="fa fa-check-square"></i>
                            {{ item.approval_at }}
                        </span>
                    </div>

                    <div v-html="item.body"></div> 
                </div>

                <div class="modal-footer">
                    <!-- todo: i18n -->
                    <div class="btn-group">
                        <button type="button"
                                class="btn btn-success"
                                :disabled="isApproved"
                                @click="approve">Approve</button>
                        <button type="button"
                                class="btn btn-warning"
                                :disabled="isPending"
                                @click="suspend">Suspend</button>
                        <button type="button"
                                class="btn btn-danger"
                                :disabled="isRejected"
                                @click="reject">Reject</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'item'
        ],
        computed: {
            isApproved() {
                return this.item.approval_status == 'approved';
            },
            isPending() {
                return this.item.approval_status == 'pending';
            },
            isRejected() {
                return this.item.approval_status == 'rejected';
            }
        },
        methods: {
            approve () {
                this.setApprovalStatus(1);
            },
            suspend () {
                this.setApprovalStatus(0);
            },
            reject () {
                this.setApprovalStatus(2);
            },
            setApprovalStatus (status) {
                let item = this.item;

                axios
                    .post(`/admin/product/${item.id}/approval`, {status})
                    .then(({data}) => {
                        for (var key in data) {
                            if (data.hasOwnProperty(key)) {
                                // We must mutate the original item instead of 
                                // the possibly different current `this.item`
                                item[key] = data[key];
                            }
                        }
                    });
            }
        }
    }
</script>

<style>
    .product-admin-attributes-bar > * {
        margin-right: .5em;
        white-space: nowrap;
    }
</style>
