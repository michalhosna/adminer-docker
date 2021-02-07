REPO = michalhosna/adminer
ADMINER_VERSION=4.7.9
ADMINER_FLAVOUR=-en
ADMINER_CHECKSUM=8f6c0b0988c6651d445c433a7311acb6c8d540b0b67dd108173698ddfa994a4a
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
