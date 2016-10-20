<script type="text/ng-template" id="contract_payment.html">
    <form name="rev_form" class="admin-flex-container main-body">
        <div class="form-group">
            <input placeholder="amount" name="payment" ng-model="contract.payment" type="number" class="form-control"
                   required>
        </div>
        <button ng-click="pay(contract)"
                class="btn btn-sm btn-success">Pay
        </button>
    </form>
</script>