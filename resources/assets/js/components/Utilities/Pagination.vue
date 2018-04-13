<template>
    <div class="pagination" v-show="showPagination">
        <button :disabled="! olderResults" @click.prevent="goToPage('prev')">Prev</button>
        <span>{{ paginationCount }}</span>
        <button :disabled="! newerResults" @click.prevent="goToPage('next')" >Next</button>
    </div>
</template>

<script>    
    export default {
        props: ['meta'],
        data() {
            return {
                links: {},
            }
        },
        computed: {
            newerResults() {
                if (! this.meta || this.meta.current_page === this.meta.last_page) {
                    return;
                }

                return this.meta.current_page + 1;
            },
            olderResults() {
                if (! this.meta || this.meta.current_page === 1) {
                    return;
                }

                return this.meta.current_page - 1;
            },
            showPagination() {
                if (! this.meta || this.meta.total <= this.meta.per_page) {
                    return;
                }

                return true;
            },
            paginationCount() {
                if (! this.meta) {
                    return;
                }

                const { current_page, last_page } = this.meta;

                return `${current_page} of ${last_page}`;
            },
        },
        methods: {
            goToPage(type) {
                let page = 1;
                if (type === 'next') {
                    page = this.meta.current_page + 1;
                } else {
                    page = this.meta.current_page - 1;
                }

                window.scrollTo(0, 0);

                this.$parent.$emit('paginate', page)
            },
        }
    }
</script>

<style lang="scss" scoped>
    .pagination {
        margin-top: 60px;
        text-align: center;
        display: block;

        button {
            appearance: none;
            border: 0;
            background: 0;
            padding: 0;
            margin: 0 10px;

            &:disabled {
                display: none;
            }

            &:hover {
                cursor: pointer;
            }
        }
    }
</style>
