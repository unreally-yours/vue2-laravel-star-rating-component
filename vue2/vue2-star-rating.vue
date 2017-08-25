<template>
	<div v-if="$attrs.disabled" class="vue-star-rating">
		<div class="rating-star" 
			v-for="star in stars"
			v-bind:class="['rating-star',star.highlight?'highlight':'',star.active?'active':'']" 
			>★</div>
	</div>
	<div 
		v-else
		class="vue-star-rating"
		v-bind:value="value"
	>
		<div class="rating-star" 
			v-for="star in stars"
			v-on:mouseover="over(star)"
			v-on:mouseout="out(star)"
			v-on:click="click(star)"
			v-bind:class="['rating-star',star.highlight?'highlight':'',star.active?'active':'']" 
			>★</div>
	</div>
</template>

<style lang="less">
.trans{
	-webkit-transition	:color 255ms ease-in-out;
	-moz-transition		:color 255ms ease-in-out;
	-ms-transition		:color 255ms ease-in-out;
	-o-transition		:color 255ms ease-in-out;
	transition			:color 255ms ease-in-out;
}
.vue-star-rating{
	.rating-star{
		.trans;
		float:left;
		color:#999;
		&.highlight{
			color:red;
		}
	}
	&:not([disabled='disabled']){
		.rating-star{
			cursor:pointer;
		}
	}
	&[disabled='disabled']{
		opacity:0.66;
	}
}
</style>

<script>
export default{
	data    :()=>({
		value:0,
		stars 	:[
			{
				id:0,
				highlight:false,
				active:false
			},{
				id:1,
				highlight:false,
				active:false
			},{
				id:2,
				highlight:false,
				active:false
			},{
				id:3,
				highlight:false,
				active:false
			},{
				id:4,
				highlight:false,
				active:false
			}
		]
	}),
	created(){
		if(typeof this.$attrs.value!='undefined'){
			this.init(this.$attrs.value);
		}
	},
	methods:{
		init:function(value){
			for(var i in this.stars){
				this.stars[i].active=(value>=i)?true:false;
				this.stars[i].highlight=(value>=i)?true:false;
			}
			this.value=value;
		},
		over:function(star){
			if(star.active){
				for(var i=star.id+1;this.stars[i];i++){
					this.stars[i].highlight=false;
				}
			}else{
				for(var i in this.stars){
					if(i<=star.id){
						this.stars[i].highlight=true;
					}else{
						break;
					}
				}
			}
		},
		out:function(star){
			for(var i in this.stars){
				this.stars[i].highlight=this.stars[i].active?true:false;
			}
		},
		click:function(star){
			this.value=star.id;
			for(var i in this.stars){
				this.stars[i].active=(i<=star.id)?true:false;
			}
			axios.get('/ajax/star_rating/add',{params:{
				source_id:this.$attrs.id,
				source:this.$attrs.source,
				rating:this.value
			}}).then(response=>{
				this.init(response.data.rating);
				this.$attrs.disabled=true;
			});
		}
	}
}
</script>
