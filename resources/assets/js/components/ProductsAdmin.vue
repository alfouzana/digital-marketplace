<template>
	<div>
		<table class="table table-hover">
	        <thead>
	            <tr>
	            	<!-- todo: i18n -->
	            	<th>ID</th>
	                <th>Title</th>
	                <th>Category</th>
	                <th>Approval Status</th>
	                <th>Created At</th>
	                <th>Updated At <i class="fa fa-caret-down"></i></th>
	            </tr>
	        </thead>
	        <tbody>
	        	<tr v-for="item in items" :class="'table-' + item.approval_context">
	        		<td>{{ item.id }}</td>
	        		<td>
	        			<a href="#" @click="showItem = item">
	        				{{ item.title }}
	        			</a>
	        		</td>
	        		<td>
	        			<span class="badge badge-info">
	        				{{ item.category }}
	        			</span>
	        		</td>
	        		<td>
	        			<span class="badge" :class="'badge-' + item.approval_context">
	        				{{ item.approval_status }}
	        			</span>
	        		</td>
	        		<td>{{ item.created_at }}</td>
	        		<td>{{ item.updated_at }}</td>
	        	</tr>
	        </tbody>
	    </table>

		<product-admin :item="showItem" 
					    @close="showItem = null">
		</product-admin>
	</div>
</template>

<script>
	import ProductAdmin from './ProductAdmin.vue';

	export default {
		components: {
			ProductAdmin
		},

		data () {
			return {
				items: this.products,
				showItem: null
			}
		},

		props: ['products']
	}
</script>	