<template>
	<div 
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
	-webkit-transition	:all 255ms ease-in-out;
	-moz-transition		:all 255ms ease-in-out;
	-ms-transition		:all 255ms ease-in-out;
	-o-transition		:all 255ms ease-in-out;
	transition			:all 255ms ease-in-out;
}
.vue-star-rating{
	.rating-star{
		.trans;
		float:left;
		font-size:2vw;
		color:#999;
		&.highlight{
			color:red;
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
				active:true
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
		for(var i in this.stars){
			if(this.$attrs.value>=i){
				this.stars[i].active=true;
				this.stars[i].highlight=true;
				this.value=this.$attrs.value;
			}else{
				break;
			}
		}
	},
	methods:{
		enabled:function(){
			if(typeof this.$attrs.disabled!='NaN'&&this.$attrs.disabled){
				return false;
			}
			return true;
		},
		over:function(star){
			if(this.enabled()){
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
			}
		},
		out:function(star){
			if(this.enabled()){
				for(var i in this.stars){
					if(this.stars[i].active){
						this.stars[i].highlight=true;
					}else{
						this.stars[i].highlight=false;
					}
				}
			}
		},
		click:function(star){
			if(this.enabled()){
				this.value=star.id;
				for(var i in this.stars){
					if(i<=star.id){
						this.stars[i].active=true;
					}else{
						this.stars[i].active=false;
					}
				}
			}
		}
	}
}
</script>
