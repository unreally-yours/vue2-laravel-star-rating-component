<template>
	<div v-if="$attrs.disabled" class="vue-star-rating">
		<div v-if="disabledMessage" class="disabled-message">{{disabledMessageText}}</div>
		<div v-for="star in stars" @click="disabledMessageShow()" :class="['rating-star',star.highlight?'highlight':'',star.active?'active':'']">★</div>
	</div>
	<div v-else	class="vue-star-rating" :value="value">
		<div v-for="star in stars"	@mouseover="over(star)"	@mouseout="out(star)" @click="click(star)" :class="['rating-star',star.highlight?'highlight':'',star.active?'active':'']">★</div>
	</div>
</template>

<script>
export default{
	data    :()=>({
		disabledMessage:false,
		disabledMessageText:'Нельзя проголосовать пока вы не ознакомились с материалом.',
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
		disabledMessageShow :function(){
			this.disabledMessage=true;
			setTimeout(function(){
				this.disabledMessage=false;
			}.bind(this),3333);
		},
		init 		:function(value){
			for(var i in this.stars){
				this.stars[i].active=(value>=i)?true:false;
				this.stars[i].highlight=(value>=i)?true:false;
			}
			this.value=value;
		},
		over 		:function(star){
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
		out 		:function(star){
			for(var i in this.stars){
				this.stars[i].highlight=this.stars[i].active?true:false;
			}
		},
		click 		:function(star){
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
