-include tests/test.env

test_all:
	./node_modules/mocha/bin/mocha --reporter spec tests