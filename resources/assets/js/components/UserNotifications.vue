<template>
    <li class="dropdown" v-if="notifications.length ">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            Notifications
        </a>
        <ul class="dropdown-menu">
            <li v-for="notification in notifications">
                <a href="#"> foobar </a>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        data(){
            return {
                notifications: false,
            };
        }
    }
</script>
