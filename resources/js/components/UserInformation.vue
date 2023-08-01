<template>
  <div>
    <!-- User names -->
    <div v-for="user in users" :key="user.id"></div>
    <!-- User balances and transactions -->
    <div v-for="user in users" :key="user.id"></div>
  </div>
</template>

<script>
export default {
  props: ["users", "loggedInUser"],
  data() {
    return {
      activeUser: null,
    };
  },
  methods: {
    setActiveUser(userId) {
      this.activeUser = userId;
    },
  },
  created() {
    this.setActiveUser(this.loggedInUser.id);
  },
};
</script>

<style>
</style>
