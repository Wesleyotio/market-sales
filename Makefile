APP_CONTAINER:= app
BD_CONTAINER:= market-sales-db-1

DOCKER_RUN:= docker exec -it ${APP_CONTAINER}


test:
	${DOCKER_RUN} bash -c "cd backend && composer test"

test-coverage:
	${DOCKER_RUN} bash -c "cd backend && composer test-coverage"

test-integration:
	${DOCKER_RUN} bash -c "cd backend && composer test-integration"

test-report:
	${DOCKER_RUN} bash -c "cd backend && composer test-coverage-html"

phpstan:
	${DOCKER_RUN} bash -c "cd backend && composer phpstan"

phpcs:
	${DOCKER_RUN} bash -c "cd backend && composer phpcs"

phpcbf:
	${DOCKER_RUN} bash -c "cd backend && composer phpcbf"

mess:
	${DOCKER_RUN} bash -c "cd backend && composer mess"

show-coverage:
	xdg-open backend/storage/coverage/index.html


