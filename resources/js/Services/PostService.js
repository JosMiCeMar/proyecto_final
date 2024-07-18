import { ref } from "vue";

export class PostService{
    #posts;

    constructor(){
       this.posts=ref([])
    }

    getPosts(){
        return this.posts;
    }

    async fetchAll(){
        try{
            const apiUrl = 'https://jsonplaceholder.typicode.com/posts';

            const response = await fetch(apiUrl);
            const json= await response.json();

            this.posts.value=await json;

        }catch(error){
            console.log(error);
        }
    }

    async fetchOne(id){
        try{
            const apiUrl = `https://jsonplaceholder.typicode.com/posts/${id}`;

            const response = await fetch(apiUrl);
            const json= await response.json();

            this.posts.value=await json;

        }catch(error){
            console.log(error);
        }
    }
}