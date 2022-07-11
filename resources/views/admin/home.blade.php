<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- Fonts -->





    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


</head>
<style>
    b-menu-list :active {
        background-color: black;
    }
</style>
<!-- This is a reverse engineering of the "Hyperspace"
     design from HTML5 Up! https://html5up.net/hyperspace -->

<main class="main">
    <aside class="sidebar">


        <nav class="nav">
            <h1 class="logo_text">MaMa shop</h1>
            <ul>
                <li><a href="#">首頁</a></li>
                <li><a href="#">即時訂單</a></li>
                <li><a href="#">商品管理</a></li>
                <li><a href="#">歷史訂單</a></li>
            </ul>
        </nav>
    </aside>


    <div class="right_container">
        <div class="head">
            <h2>..</h2>
        </div>

        <div class="content">
           
                <b-container fluid id="app">
                    <!-- User Interface controls -->
                    <b-row>
                        

                        

                        <b-col lg="6" class="my-1">
                            <b-form-group label="Filter" label-for="filter-input" label-cols-sm="3" label-align-sm="right" label-size="sm" class="mb-0">
                                <b-input-group size="sm">
                                    <b-form-input id="filter-input" v-model="filter" type="search" placeholder="Type to Search"></b-form-input>

                                    <b-input-group-append>
                                        <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                                    </b-input-group-append>
                                </b-input-group>
                            </b-form-group>
                        </b-col>

                        <b-col lg="6" class="my-1">
                            <b-form-group v-model="sortDirection" label="Filter On" description="Leave all unchecked to filter on all data" label-cols-sm="3" label-align-sm="right" label-size="sm" class="mb-0" v-slot="{ ariaDescribedby }">
                                <b-form-checkbox-group v-model="filterOn" :aria-describedby="ariaDescribedby" class="mt-1">
                                    <b-form-checkbox value="name">Name</b-form-checkbox>
                                    <b-form-checkbox value="age">Age</b-form-checkbox>
                                    <b-form-checkbox value="isActive">Active</b-form-checkbox>
                                </b-form-checkbox-group>
                            </b-form-group>
                        </b-col>

                        

                        
                    </b-row>

                    <!-- Main table element -->
                    <div class="ttbody">
                    <b-table   hover :items="items" :fields="fields"  :tbody-tr-class="rowClass"  :current-page="currentPage" :per-page="perPage" :filter="filter" :filter-included-fields="filterOn" stacked="md" show-empty small @filtered="onFiltered">
                    
                    <template #cell(name)="row">
                        
                        @{{ row.value.first }} @{{ row.value.last }}
                           
                        </template>

                        <template #cell(actions)="row">
                            <b-button size="sm" @click="info(row.item, row.index, $event.target)" class="mr-1">
                                Info modal
                            </b-button>
                            <b-button size="sm" @click="row.toggleDetails">
                                @{{ row.detailsShowing ? 'Hide' : 'Show' }} Details
                            </b-button>
                        </template>

                        <template #row-details="row">
                            <b-card>
                                <ul>
                                    <li  v-for="(value, key) in row.item" :key="key">@{{ key }}: @{{ value }}</li>
                                </ul>
                            </b-card>
                        </template>
                        
                    </b-table>
</div>
                   
                        

                    <!-- Info modal -->
                    <b-modal :id="infoModal.id" :title="infoModal.title" ok-only @hide="resetInfoModal">
                        <pre>@{{ infoModal.content }}</pre>
                    </b-modal>
                    <b-col  md="12" class="my-1">
                            <b-pagination v-model="currentPage" :total-rows="totalRows" :per-page="perPage" align="fill" size="sm" class="my-0"></b-pagination>
                        </b-col>   
                </b-container>
               
            


        </div>



    </div>

</main>


</body>

<script>
    //     var aaa = new Vue({
    //   el: '#aaa',
    //   data: {
    //     message: 'Hello Vue!'
    //   }
    // })

    //     const example = {
    //   data() {
    //     return {
    //       open: true,
    //       overlay: false,
    //       fullheight: true,
    //       fullwidth: false,
    //       right: false
    //     };
    //   }
    // };

    //                 const app = new Vue(example)
    //                 app.$mount('#app')

    const table_product = {
        data() {
            return {
                items: [{
                        
                        age: 40,
                        name: {
                            first: 'Dickerson',
                            last: 'Macdonald'
                        }
                    },
                    {
                        
                        age: 21,
                        name: {
                            first: 'Larsen',
                            last: 'Shaw'
                        }
                    },
                    {
                        
                        age: 9,
                        name: {
                            first: 'Mini',
                            last: 'Navarro'
                        },
                        
                    },
                    {
                        
                        age: 89,
                        name: {
                            first: 'Geneva',
                            last: 'Wilson'
                        }
                    },
                    {
                        
                        age: 38,
                        name: {
                            first: 'Jami',
                            last: 'Carney'
                        }
                    },
                    {
                        
                        age: 27,
                        name: {
                            first: 'Essie',
                            last: 'Dunlap'
                        }
                    },
                    {
                       
                        age: 40,
                        name: {
                            first: 'Thor',
                            last: 'Macdonald'
                        }
                    },
                    {
                       
                        age: 87,
                        name: {
                            first: 'Larsen',
                            last: 'Shaw'
                        },
                        
                    },
                    {
                        age: 26,
                        name: {
                            first: 'Mitzi',
                            last: 'Navarro'
                        }
                    },
                    {
                       
                        age: 22,
                        name: {
                            first: 'Genevieve',
                            last: 'Wilson'
                        }
                    },
                    {
                       
                        age: 38,
                        name: {
                            first: 'John',
                            last: 'Carney'
                        }
                    },
                    {
                       
                        age: 29,
                        name: {
                            first: 'Dick',
                            last: 'Dunlap'
                        }
                    }
                ],
                fields: [{
                        key: 'name',
                        label: 'Person full name',
                        sortable: true,
                        sortDirection: 'desc'
                    },
                    {
                        key: 'age',
                        label: 'Person age',
                        sortable: true,
                        class: 'text-center'
                    },
                    
                    {
                        key: 'actions',
                        label: 'Actions'
                    }
                ],
                
                totalRows: 1,
                currentPage: 1,
                perPage: 5,
                pageOptions: [5, 10, 15, {
                    value: 100,
                    text: "Show a lot"
                }],
                
                filter: null,
                filterOn: [],
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: ''
                }
            }
        },
        computed: {
            sortOptions() {
                // Create an options list from our fields
                return this.fields
                    .filter(f => f.sortable)
                    .map(f => {
                        return {
                            text: f.label,
                            value: f.key
                        }
                    })
            }
        },
        mounted() {
            // Set the initial number of items
            this.totalRows = this.items.length
        },
        methods: {
            tabody(item, type) {
        return 'ttbody';
      },
            rowClass(item, type) {
        return 'tr_card td';
      },
            info(item, index, button) {
                this.infoModal.title = `Row index: ${index}`
                this.infoModal.content = JSON.stringify(item, null, 2)
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)
            },
            resetInfoModal() {
                this.infoModal.title = ''
                this.infoModal.content = ''
            },
            onFiltered(filteredItems) {
                // Trigger pagination to update the number of buttons/pages due to filtering
                this.totalRows = filteredItems.length
                this.currentPage = 1
            }
        }
    }
    const app = new Vue(table_product)
    app.$mount('#app')
</script>