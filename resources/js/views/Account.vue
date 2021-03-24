<template>
    <div class="container account_container">
        <p>Account Overview</p>
        <p>Here you can manage your public/private keys, and view or manage song requests that you have received</p>
        <div class="account_container_grid">
            <div>
                <h1>Account Keys</h1>
                <hr>
                <div>
                    <p>
                        Your public key is used by others to send your requests. <br/> Hand this out to anyone who you want to submit requests <br/>
                        Public Key: <u><a :href="'/requests/' + User.public_key">{{ User.public_key }}</a></u>
                    </p>
                </div>
                <hr>
                <div>
                    <p>
                        Your private key is used to fetch the requests in-game. <br/> <u>Do not share this with anyone!</u> <br/>
                        Private Key: <pre>{{ User.private_key }}</pre>
                    </p>
                </div>
                <hr>
            </div>
            <div id="request_list">
                <h1>Song Requests</h1>
                <hr>
                <p>View and manage your current requests and request history</p>
                <h3>Open requests</h3>
                <table id="request_list_table">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr v-for="request in openRequests" :key="request.id" >
                        <td><img :src="request.coverURL" class="request_list_cover_image" /></td>
                        <td>{{ request.songAuthor }} - {{ request.songName }}</td>
                        <td>
                            <button>Block song</button>
                        </td>
                        <td>
                            <button>Block requester</button>
                        </td>
                        <td>
                            <button>Delete request</button>
                        </td>
                    </tr>
                </table>
                <hr>
                <h3>Request history</h3>
                <table id="request_list_table">
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr v-for="request in fetchedRequests" :key="request.id" >
                        <td><img :src="request.coverURL" class="request_list_cover_image" /></td>
                        <td>{{ request.songAuthor }} - {{ request.songName }}</td>
                        <td>
                            <button>Block song</button>
                        </td>
                        <td>
                            <button>Block requester</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            User: window.User,
            fetchedRequests: [],
            openRequests: []
        }
    },

    mounted() {
        axios.get('/app/requests/list').then(res => {
            res.data.forEach(request => {
                if (request.fetched == 1) {    
                    this.fetchedRequests.push(request);
                } else {
                    this.openRequests.push(request);
                }
            });
        });
    }
}
</script>

<style lang="scss">
    .account_container {
        height: 100%;

        p, h1, h3  {
            text-align: center;
        }

        a:link, a:visited {
            color: white;
        }
        
        .account_container_grid {
            display: grid;
            grid-template-columns: 40% 60%;
            grid-gap: 10px;
            justify-content: center;
            height: 83%;
        }

        .account_container_grid > div {
            padding: 10px;
            background-color: gray;
            border-radius: 25px;
        }
    }

    #request_list {
        overflow-y: scroll;
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    #request_list::-webkit-scrollbar {
        display: none;
    }

    #request_list_table {
        button {
            background-color: red;
            border: none;
            user-select: none;
            border-radius: 25px;
            padding: 5px 10px;
        }

        td {
            padding: 3px;
        }
    }

    .request_list_cover_image {
        width: 50px;
        height: 50px;
        border-radius: 50%;
    }

</style>