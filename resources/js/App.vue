<template>
    <div>some text</div>
</template>
<script>
export default{
    created(){
        window.Echo.channel('new-article-channel').listen('NewArticle', (name)=>{
            alert('Добавлена статья');
            console.log('name');
        })
    }
}
</script>
