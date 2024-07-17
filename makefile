update:
	@echo "Fetching latest changes from the remote repository..."
	@git fetch
	@echo "Pulling latest changes from the origin dev branch..."
	@git pull origin

.PHONY: update
