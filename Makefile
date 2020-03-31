REPO = michalhosna/adminer
ADMINER_VERSION=4.7.6
ADMINER_FLAVOUR=-en
ADMINER_CHECKSUM=a136594a415918319e9d963784d388f03df90831796c5ac2b778d4321a99d473
TAG=$(ADMINER_VERSION)$(ADMINER_FLAVOUR)_v1

all: build publish

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
