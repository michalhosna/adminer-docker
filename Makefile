REPO = michalhosna/adminer
ADMINER_VERSION=4.8.0
ADMINER_FLAVOUR=-en
ADMINER_CHECKSUM=e1abf288b5a88d6c41c25336dc82d3e7a01e17232f2a93d5976d630a5938ed8b
TAG=$(ADMINER_VERSION)$(ADMINER_FLAVOUR)_v1

all: build publish latest

build:
	docker build \
		--build-arg ADMINER_VERSION=$(ADMINER_VERSION) \
		--build-arg ADMINER_CHECKSUM=$(ADMINER_CHECKSUM) \
		--build-arg ADMINER_FLAVOUR=$(ADMINER_FLAVOUR) \
		-t $(REPO):$(TAG) \
		src

publish:
	docker push $(REPO):$(TAG)

latest:
	docker tag $(REPO):$(TAG) $(REPO):latest
	docker push $(REPO):latest

.PHONY: all build publish
