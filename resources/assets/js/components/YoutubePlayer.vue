<template>
    <div>
        <video v-if="type == 1" width="100%" height="640" controls autoplay>
            <source v-bind:src="url" type="video/mp4">
            Этот браузер не поддерживает тег HTML5 video.
        </video>

        <iframe v-if="type == 0" type="text/html" width="100%" height="640" frameborder="0" allowfullscreen
                v-bind:src="video_url" v-bind:id="component_id" v-on:load="video_loaded"
        ></iframe>
    </div>
</template>

<script>
    export default {
        props:['id', 'url', 'code', 'type', 'origin'],
        data:function() {
            return {
                component_id: this.id ? this.id : 'youtube',
                video_url: 'https://www.youtube.com/embed/' + this.code
                    + '?autoplay=1&controls=1&playsinline=1&rel=0&showinfo=0'
                    + '&origin=' + (this.origin ? this.origin : 'https://kidstube.space')
            };
        },
        mounted() {
            console.log('Youtube Player mounted.')
        },
        methods:{
            video_loaded() {
                let iframe = $('#' + this.component_id)[0];
                console.log('video loaded: ' + iframe);
                iframe.contentWindow.onunload = this.video_unloading;
            },
            video_unloading(e) {
                console.log('video unloading');
                e.preventDefault();
                e.stopImmediatePropagation();
                return false;
            }
        }
    }
</script>
