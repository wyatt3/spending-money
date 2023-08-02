<template>
  <table class="table table-dark">
    <thead>
      <tr>
        <th>Amount</th>
        <th>Description</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="transaction in transactions"
        :key="transaction.id"
        @click="deleteTransaction(transaction.id)"
      >
        <td
          :class="{
            'text-danger': transaction.amount < 0,
            'text-success': transaction.amount >= 0,
          }"
        >
          {{ formatAmount(transaction.amount) }}
        </td>
        <td>{{ transaction.description }}</td>
        <td>{{ formatDate(transaction.created_at) }}</td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  props: ["transactions"],
  methods: {
    formatAmount(amount) {
      return amount.toLocaleString("en-US", {
        style: "currency",
        currency: "USD",
      });
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString("en-US");
    },
    deleteTransaction(id) {
      if (confirm("Are you sure you want to delete this transaction?")) {
        axios
          .post("/api/transactions/delete", {
            id: id,
          })
          .then((response) => {
            this.$emit("deleted", response.data);
          });
      }
    },
  },
};
</script>

<style>
</style>
