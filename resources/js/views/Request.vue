<template>
    <div id="request">
        <div id="alert_container" v-if="alert != null">
            <div id="alert" :class="alertStyle">
                <span>{{ alert.message }}</span>
            </div>
        </div>

        <div class="song_preview_container">
            <spinner v-if="searching"></spinner>

            <div class="song_preview" v-if="songPreview !== null">
                <img id="song_preview_image" :src="songPreview.coverURL">
                <div id="song_preview_description">
                    <pre>{{songPreview.description}}</pre>
                </div>
                <div id="song_preview_information">
                    <div id="song_preview_information_stats">
                        <div>
                            Song <br/>
                            {{songPreview.metadata.songAuthorName}} - {{songPreview.metadata.songName}} <br/>
                            Mapped by {{songPreview.metadata.levelAuthorName}}
                        </div>
                        <div>
                            Stats <br/>
                            Likes: {{songPreview.stats.upVotes}} <br/>
                            Dislikes: {{songPreview.stats.downVotes}} <br/>
                            Downloads: {{songPreview.stats.downloads}} <br/>
                            Duration: {{songPreview.metadata.duration}}
                        </div>
                        <div>
                            Difficulties <br/>
                            <pre v-for="difficulty in songPreview.difficulties" :key="difficulty">{{difficulty}}</pre>
                        </div>
                    </div>
                    <div id="song_preview_information_submit">
                        <button class="confirm" @click="requestSong">Request</button>
                        <button class="cancel" @click="cancelSearch">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="search_form">
            <input type="text" v-model="search" placeholder="Song ID (https://beatsaver.com/)">
            <button @click="searchSong">Search</button>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            searching: false,
            search: '',
            songPreview: null,
            alert: null,
        }
    },

    methods: {
        searchSong() {
            if(this.search.length == 0) return;

            this.searching = true;
            this.songPreview = null;
            this.alert = null;

            axios.get(`https://beatsaver.com/api/maps/detail/${this.search}`).then(res => {
                this.searching = false;

                let song = res.data;
                song.coverURL = `https://beatsaver.com${song.coverURL}`;

                song.difficulties = [];
                
                if (song.metadata.difficulties.easy) { song.difficulties.push('Easy'); }
                if (song.metadata.difficulties.normal) { song.difficulties.push('Normal'); }
                if (song.metadata.difficulties.hard) { song.difficulties.push('Hard'); }
                if (song.metadata.difficulties.expert) { song.difficulties.push('Expert'); }
                if (song.metadata.difficulties.expertPlus) { song.difficulties.push('Expert+'); }

                this.songPreview = song;
                this.search = '';
            }).catch(err => {
                this.search = '';
                this.searching = false;
                this.songPreview = null;
                this.alert = {
                    type: 'error',
                    message: 'Song not found. Is it a valid https://beatsaver.com ID?'
                };
            });
        },

        requestSong() {
            let data = {
                public_key: this.$route.params.id,
                song: this.songPreview.key
            }

            axios.post(`/app/requests/create`, data).then(res => {
                this.alert = {
                     type: 'success',
                     message: 'Song has been requested!'
                }
            }).catch(err => {
                this.alert = {
                     type: 'error',
                     message: err.response.data
                }
            });
        },

        cancelSearch() {
            this.search = '';
            this.searching = false;
            this.songPreview = null;
            this.alert = null;
        }
    },

    computed: {
        alertStyle() {
            return this.alert != null ? this.alert.type : '';
        }
    }
}
</script>

<style>
    #request button {
        background-color: cyan;
        border: none;
        border-radius: 25px;
        padding: 5px;
        color: black;
    }

    .song_preview_container {
        position: fixed;
        top: 85px;
        left: 50%;
        transform: translate(-50%, 0%);
        
        width: 80%;
        max-width: 80%;
        height: 70%;

        color: white;
        font-size: 15px;
    }

    .song_preview {
        display: grid;
        width: 100%;
        height: 100%;

        grid-template-columns: 250px auto;
        grid-template-rows: 250px auto;
        grid-gap: 10px;

    }

    #song_preview_image {
        width: 250px;
        height: 250px;
        border-radius: 25px;
    }

    #song_preview_description {
        background-color: gray;
        border-radius: 25px;
        padding: 10px;
    }

    #song_preview_description pre {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
    }

    #song_preview_information {
        grid-column: 1 / 3;

        background-color: gray;
        border-radius: 25px;
        padding: 10px;

        display: grid;
        grid-template-columns: auto 35%;
    }

    #song_preview_information > div:first-child {
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);

        display: inline-grid;
        grid-gap: 20px;
        grid-template-columns: auto auto auto;
    }

    #song_preview_information > div:last-child {
        position: relative;
        top: 50%;
        right: 0px;
        transform: translate(0%, -50%);
    }

    #song_preview_information_submit > button {
        width: 200px;
        margin-top: 20px;
        float: right;
    }

    #song_preview_information_submit > button.confirm {
        background-color: lime;
    }

    #song_preview_information_submit > button.cancel {
        background-color: red
    }

    .search_form {
        position: fixed;
        bottom: 15px;
        left: 50%;
        transform: translate(-50%, 0%);
        width: 65%
    }

    .search_form input {
        border: 1px solid gray;
        border-radius: 15px;
        padding: 3px;
        width: 80%;
        height: 40px;
        text-align: center;

        color: black;
    }

    .search_form > input:focus, .search_form > button:focus{
        outline: none;
    }

    .search_form > button {
        padding: 8px;
        width: 100px;
    }

    #alert_container {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
    }

    #alert {
        width: 30vw;
        height: 50px;
        color: white;
        user-select: none;
        border-radius: 10px;
        text-align: center;
    }

    #alert > span {
        line-height: 50px;
    }

    #alert.error {
        background-color: rgb(235, 11, 11);
    }

    #alert.success {
        background-color: rgb(0, 160, 0);
    }
</style>