import json
from pathlib import Path

REQUIRED_FIELDS = ("name", "city", "category")


def load_json_file(json_file_path):
    content = json_file_path.read_text(encoding="utf-8")
    data = json.loads(content)

    return data


def main() -> int:
    script_directory = Path(__file__).parent
    json_file_path = script_directory / "example.json"

    if not json_file_path.exists():
        print("JSON file not found:", json_file_path)
        return 1

    try:
        data = load_json_file(json_file_path)
    except json.JSONDecodeError as error:
        print("Invalid JSON:", error)
        return 1

    for field in REQUIRED_FIELDS:
        if field not in data:
            print("Missing required field:", field)
            return 1

    print("Name:", data["name"])
    print("City:", data["city"])
    print("Category:", data["category"])

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
