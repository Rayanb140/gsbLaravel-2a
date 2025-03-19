<div class="alert alert-danger">
    <div class="alert-icon">
        <i class="fas fa-exclamation-triangle"></i>
    </div>
    <div class="alert-content">
        <ul class="alert-list">
            @foreach($erreurs as $erreur)
                <li>{{ $erreur }}</li>
            @endforeach
        </ul>
    </div>
</div>

<style>
.alert {
    display: flex;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 25px;
    background-color: #fdf0f0;
    border-left: 4px solid #e74c3c;
    color: #e74c3c;
}

.alert-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    font-size: 18px;
}

.alert-content {
    flex: 1;
}

.alert-list {
    margin: 0;
    padding-left: 20px;
}

.alert-list li {
    margin-bottom: 5px;
}

.alert-list li:last-child {
    margin-bottom: 0;
}
</style>