<div class="alert alert-success">
    <div class="alert-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="alert-content">
        {{ $message }}
    </div>
</div>

<style>
.alert {
    display: flex;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 25px;
    align-items: center;
}

.alert-success {
    background-color: #e6f7ef;
    color: #27ae60;
    border-left: 4px solid #27ae60;
}

.alert-icon {
    margin-right: 15px;
    font-size: 18px;
}

.alert-content {
    flex: 1;
}
</style>